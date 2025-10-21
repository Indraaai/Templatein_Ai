<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\DocumentCheck;
use App\Models\Template;
use App\Services\GroqService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DocumentCheckController extends Controller
{
    protected $groqService;

    public function __construct(GroqService $groqService)
    {
        $this->groqService = $groqService;
    }

    /**
     * Display a listing of document checks
     */
    public function index(Request $request)
    {
        $query = DocumentCheck::where('user_id', Auth::id())
            ->with(['template'])
            ->latest();

        // Filter by status
        if ($request->filled('status')) {
            $query->where('approval_status', $request->status);
        }

        // Filter by check_status
        if ($request->filled('check_status')) {
            $query->where('check_status', $request->check_status);
        }

        // Search by filename
        if ($request->filled('search')) {
            $query->where('original_filename', 'like', '%' . $request->search . '%');
        }

        $documents = $query->paginate(12);

        return view('student.documents.index', compact('documents'));
    }

    /**
     * Show the form for creating a new document check
     */
    public function create()
    {
        $user = Auth::user();

        // Get templates sesuai fakultas & prodi mahasiswa
        $templates = Template::where('faculty_id', $user->faculty_id)
            ->where('program_study_id', $user->program_study_id)
            ->where('is_active', true)
            ->get();

        return view('student.documents.create', compact('templates'));
    }

    /**
     * Store a newly created document check
     */
    public function store(Request $request)
    {
        $request->validate([
            'template_id' => 'required|exists:templates,id',
            'document' => 'required|file|mimes:pdf,doc,docx|max:10240', // 10MB max
        ], [
            'template_id.required' => 'Silakan pilih template dokumen',
            'document.required' => 'File dokumen wajib diupload',
            'document.mimes' => 'File harus berformat PDF, DOC, atau DOCX',
            'document.max' => 'Ukuran file maksimal 10MB',
        ]);

        try {
            $user = Auth::user();
            $file = $request->file('document');
            $template = Template::findOrFail($request->template_id);

            // Validasi template sesuai dengan fakultas & prodi mahasiswa
            if (
                $template->faculty_id !== $user->faculty_id ||
                $template->program_study_id !== $user->program_study_id
            ) {
                return back()->with('error', 'Template tidak sesuai dengan fakultas dan program studi Anda.');
            }

            // Generate unique filename
            $filename = Str::uuid() . '.' . $file->getClientOriginalExtension();

            // Store file
            $filePath = $file->storeAs(
                'documents/originals/' . $user->id,
                $filename,
                'public'
            );

            // Create document check record
            $documentCheck = DocumentCheck::create([
                'user_id' => $user->id,
                'template_id' => $template->id,
                'original_filename' => $file->getClientOriginalName(),
                'file_path' => $filePath,
                'file_type' => $file->getClientOriginalExtension(),
                'file_size' => $file->getSize(),
                'check_status' => 'pending',
                'approval_status' => 'pending',
            ]);

            // Dispatch AI analysis job (akan kita buat nanti)
            // ProcessDocumentAnalysis::dispatch($documentCheck);

            // Atau proses langsung jika tidak pakai queue
            $this->processAIAnalysis($documentCheck);

            return redirect()
                ->route('student.documents.show', $documentCheck)
                ->with('success', 'Dokumen berhasil diupload dan sedang dianalisis oleh AI.');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified document check
     */
    public function show(DocumentCheck $document)
    {
        // Authorization check
        if ($document->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke dokumen ini.');
        }

        $document->load(['template', 'user', 'checker']);

        return view('student.documents.show', compact('document'));
    }

    /**
     * Download original document
     */
    public function downloadOriginal(DocumentCheck $document)
    {
        // Authorization check
        if ($document->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke dokumen ini.');
        }

        // Check if file exists
        if (!Storage::disk('public')->exists($document->file_path)) {
            return back()->with('error', 'File tidak ditemukan.');
        }

        $filePath = Storage::disk('public')->path($document->file_path);
        return response()->download($filePath, $document->original_filename);
    }

    /**
     * Download corrected document
     */
    public function downloadCorrected(DocumentCheck $document)
    {
        // Authorization check
        if ($document->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke dokumen ini.');
        }

        // Check if corrected file exists
        if (!$document->corrected_file_path || !Storage::disk('public')->exists($document->corrected_file_path)) {
            return back()->with('error', 'File hasil koreksi tidak tersedia.');
        }

        $filePath = Storage::disk('public')->path($document->corrected_file_path);
        return response()->download($filePath, $document->corrected_filename ?? 'corrected_' . $document->original_filename);
    }

    /**
     * Download AI feedback as text file
     */
    public function downloadFeedback(DocumentCheck $document)
    {
        // Authorization check
        if ($document->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke dokumen ini.');
        }

        if (!$document->ai_feedback) {
            return back()->with('error', 'Feedback AI tidak tersedia.');
        }

        $feedback = $this->formatFeedbackForDownload($document);

        $filename = 'feedback_' . Str::slug($document->original_filename) . '.txt';

        return response($feedback)
            ->header('Content-Type', 'text/plain')
            ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');
    }

    /**
     * Recheck document (re-run AI analysis)
     */
    public function recheck(DocumentCheck $document)
    {
        // Authorization check
        if ($document->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke dokumen ini.');
        }

        try {
            // Reset status
            $document->update([
                'check_status' => 'pending',
                'ai_result' => null,
                'violations' => null,
                'suggestions' => null,
                'ai_score' => null,
                'ai_feedback' => null,
            ]);

            // Re-process AI analysis
            $this->processAIAnalysis($document);

            return redirect()
                ->route('student.documents.show', $document)
                ->with('success', 'Dokumen sedang dianalisis ulang oleh AI.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Delete document
     */
    public function destroy(DocumentCheck $document)
    {
        // Authorization check
        if ($document->user_id !== Auth::id()) {
            abort(403, 'Anda tidak memiliki akses ke dokumen ini.');
        }

        try {
            // Delete files from storage
            if (Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            if ($document->corrected_file_path && Storage::disk('public')->exists($document->corrected_file_path)) {
                Storage::disk('public')->delete($document->corrected_file_path);
            }

            // Delete record
            $document->delete();

            return redirect()
                ->route('student.documents.index')
                ->with('success', 'Dokumen berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Process AI Analysis
     */
    protected function processAIAnalysis(DocumentCheck $documentCheck)
    {
        try {
            // Update status to processing
            $documentCheck->update(['check_status' => 'processing']);

            $filePath = Storage::disk('public')->path($documentCheck->file_path);
            $template = $documentCheck->template;

            // Extract text from document
            $content = $this->extractTextFromDocument($filePath, $documentCheck->file_type);

            if (!$content) {
                throw new \Exception('Gagal mengekstrak teks dari dokumen.');
            }

            // Analyze with Groq AI
            $analysisResult = $this->groqService->analyzeDocument(
                $content,
                $template->rules ?? [],
                $template->name
            );

            if (!$analysisResult) {
                throw new \Exception('AI gagal menganalisis dokumen.');
            }

            // Generate correction suggestions file
            $correctionText = $this->groqService->generateCorrectionSuggestions($analysisResult);
            $correctedFilePath = $this->saveCorrectionFile($documentCheck, $correctionText);

            // Update document check with results
            $documentCheck->update([
                'ai_result' => $analysisResult,
                'violations' => $analysisResult['violations'] ?? [],
                'suggestions' => $analysisResult['suggestions'] ?? [],
                'ai_score' => $analysisResult['overall_score'] ?? 0,
                'compliance_score' => $analysisResult['overall_score'] ?? 0,
                'ai_feedback' => $analysisResult['ai_feedback'] ?? $analysisResult['summary'] ?? '',
                'check_status' => 'completed',
                'approval_status' => $analysisResult['status'] ?? 'pending',
                'ai_checked_at' => now(),
                'corrected_file_path' => $correctedFilePath,
                'corrected_filename' => 'saran_perbaikan_' . $documentCheck->original_filename . '.txt',
            ]);
        } catch (\Exception $e) {
            // Update status to failed
            $documentCheck->update([
                'check_status' => 'failed',
                'ai_feedback' => 'Error: ' . $e->getMessage(),
            ]);

            Log::error('AI Analysis Failed', [
                'document_id' => $documentCheck->id,
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
            ]);
        }
    }

    /**
     * Extract text from document based on file type
     */
    protected function extractTextFromDocument(string $filePath, string $fileType)
    {
        try {
            if ($fileType === 'pdf') {
                return $this->groqService->extractTextFromPdf($filePath);
            } elseif (in_array($fileType, ['doc', 'docx'])) {
                return $this->groqService->extractTextFromDocx($filePath);
            }

            return null;
        } catch (\Exception $e) {
            Log::error('Text Extraction Failed', [
                'file' => $filePath,
                'type' => $fileType,
                'error' => $e->getMessage(),
            ]);
            return null;
        }
    }

    /**
     * Save correction suggestions to file
     */
    protected function saveCorrectionFile(DocumentCheck $documentCheck, string $content)
    {
        try {
            $filename = 'saran_perbaikan_' . Str::uuid() . '.txt';
            $path = 'documents/corrected/' . $documentCheck->user_id . '/' . $filename;

            Storage::disk('public')->put($path, $content);

            return $path;
        } catch (\Exception $e) {
            Log::error('Save Correction File Failed', ['error' => $e->getMessage()]);
            return null;
        }
    }

    /**
     * Format feedback for download
     */
    protected function formatFeedbackForDownload(DocumentCheck $document)
    {
        $output = "=" . str_repeat("=", 70) . "\n";
        $output .= "HASIL ANALISIS AI - DOKUMEN MAHASISWA\n";
        $output .= "=" . str_repeat("=", 70) . "\n\n";

        $output .= "Dokumen      : " . $document->original_filename . "\n";
        $output .= "Template     : " . $document->template->name . "\n";
        $output .= "Tanggal Check: " . $document->ai_checked_at->format('d F Y, H:i') . "\n";
        $output .= "Score AI     : " . $document->ai_score . "/100\n";
        $output .= "Status       : " . strtoupper($document->approval_status) . "\n\n";

        $output .= str_repeat("-", 72) . "\n";
        $output .= "RINGKASAN\n";
        $output .= str_repeat("-", 72) . "\n";
        $output .= $document->ai_feedback . "\n\n";

        if (!empty($document->violations)) {
            $output .= str_repeat("-", 72) . "\n";
            $output .= "PELANGGARAN YANG DITEMUKAN\n";
            $output .= str_repeat("-", 72) . "\n";
            foreach ($document->violations as $index => $violation) {
                $num = $index + 1;
                $output .= "\n{$num}. [{$violation['severity']}] {$violation['issue']}\n";
                $output .= "   Lokasi    : {$violation['location']}\n";
                $output .= "   Diharapkan: {$violation['expected']}\n";
                $output .= "   Ditemukan : {$violation['found']}\n";
            }
            $output .= "\n";
        }

        if (!empty($document->suggestions)) {
            $output .= str_repeat("-", 72) . "\n";
            $output .= "SARAN PERBAIKAN\n";
            $output .= str_repeat("-", 72) . "\n";
            foreach ($document->suggestions as $index => $suggestion) {
                $num = $index + 1;
                $output .= "{$num}. {$suggestion}\n";
            }
            $output .= "\n";
        }

        $output .= "=" . str_repeat("=", 70) . "\n";
        $output .= "Generated by Template.in AI System\n";
        $output .= date('Y-m-d H:i:s') . "\n";
        $output .= "=" . str_repeat("=", 70) . "\n";

        return $output;
    }
}
