<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DocumentCheck;
use App\Models\User;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class DocumentReviewController extends Controller
{
    /**
     * Display a listing of documents for review
     */
    public function index(Request $request)
    {
        $query = DocumentCheck::with(['user', 'template', 'checker'])
            ->latest();

        // Filter by approval status
        if ($request->filled('status')) {
            $query->where('approval_status', $request->status);
        }

        // Filter by check status
        if ($request->filled('check_status')) {
            $query->where('check_status', $request->check_status);
        }

        // Filter by student
        if ($request->filled('student_id')) {
            $query->where('user_id', $request->student_id);
        }

        // Filter by template
        if ($request->filled('template_id')) {
            $query->where('template_id', $request->template_id);
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('original_filename', 'like', '%' . $request->search . '%')
                    ->orWhereHas('user', function ($userQuery) use ($request) {
                        $userQuery->where('name', 'like', '%' . $request->search . '%');
                    });
            });
        }

        $documents = $query->paginate(20);

        // Statistics for summary cards
        $stats = [
            'total' => DocumentCheck::count(),
            'pending' => DocumentCheck::where('approval_status', 'pending')
                ->where('check_status', 'completed')
                ->count(),
            'approved' => DocumentCheck::where('approval_status', 'approved')->count(),
            'rejected' => DocumentCheck::where('approval_status', 'rejected')->count(),
        ];

        return view('admin.documents.index', compact('documents', 'stats'));
    }

    /**
     * Display the specified document for review
     */
    public function show(DocumentCheck $document)
    {
        $document->load(['user', 'template', 'checker']);

        return view('admin.documents.show', compact('document'));
    }

    /**
     * Approve document
     */
    public function approve(Request $request, DocumentCheck $document)
    {
        $request->validate([
            'notes' => 'nullable|string|max:1000',
        ]);

        try {
            $document->update([
                'approval_status' => 'approved',
                'checked_by' => Auth::id(),
                'checked_at' => now(),
                'admin_notes' => $request->notes,
            ]);

            // TODO: Send notification to student
            // Notification::send($document->user, new DocumentApprovedNotification($document));

            return back()->with('success', 'Dokumen berhasil disetujui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Reject document
     */
    public function reject(Request $request, DocumentCheck $document)
    {
        $request->validate([
            'notes' => 'required|string|max:1000',
        ], [
            'notes.required' => 'Alasan penolakan wajib diisi.',
        ]);

        try {
            $document->update([
                'approval_status' => 'rejected',
                'checked_by' => Auth::id(),
                'checked_at' => now(),
                'admin_notes' => $request->notes,
            ]);

            // TODO: Send notification to student
            // Notification::send($document->user, new DocumentRejectedNotification($document));

            return back()->with('success', 'Dokumen telah ditolak.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Request revision for document
     */
    public function requestRevision(Request $request, DocumentCheck $document)
    {
        $request->validate([
            'notes' => 'required|string|max:1000',
        ], [
            'notes.required' => 'Catatan revisi wajib diisi.',
        ]);

        try {
            $document->update([
                'approval_status' => 'need_revision',
                'checked_by' => Auth::id(),
                'checked_at' => now(),
                'admin_notes' => $request->notes,
            ]);

            // TODO: Send notification to student
            // Notification::send($document->user, new DocumentNeedRevisionNotification($document));

            return back()->with('success', 'Permintaan revisi telah dikirim ke mahasiswa.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Download original document
     */
    public function downloadOriginal(DocumentCheck $document)
    {
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
        if (!$document->corrected_file_path || !Storage::disk('public')->exists($document->corrected_file_path)) {
            return back()->with('error', 'File hasil koreksi tidak tersedia.');
        }

        $filePath = Storage::disk('public')->path($document->corrected_file_path);
        return response()->download($filePath, $document->corrected_filename ?? 'corrected_' . $document->original_filename);
    }

    /**
     * Bulk approve documents
     */
    public function bulkApprove(Request $request)
    {
        $request->validate([
            'document_ids' => 'required|array',
            'document_ids.*' => 'exists:document_checks,id',
        ]);

        try {
            DocumentCheck::whereIn('id', $request->document_ids)
                ->update([
                    'approval_status' => 'approved',
                    'checked_by' => Auth::id(),
                    'checked_at' => now(),
                ]);

            return back()->with('success', count($request->document_ids) . ' dokumen berhasil disetujui.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Statistics dashboard
     */
    public function statistics()
    {
        // Basic counts
        $stats = [
            'total_documents' => DocumentCheck::count(),
            'pending_review' => DocumentCheck::where('approval_status', 'pending')
                ->where('check_status', 'completed')
                ->count(),
            'approved' => DocumentCheck::where('approval_status', 'approved')->count(),
            'rejected' => DocumentCheck::where('approval_status', 'rejected')->count(),
            'revision' => DocumentCheck::where('approval_status', 'revision')->count(),
            'total_students' => User::where('role', 'mahasiswa')
                ->whereHas('documentChecks')
                ->count(),
        ];

        // Score distribution
        $stats['completed_checks'] = DocumentCheck::whereNotNull('ai_score')->count();
        $stats['score_90_100'] = DocumentCheck::where('ai_score', '>=', 90)->count();
        $stats['score_80_89'] = DocumentCheck::whereBetween('ai_score', [80, 89])->count();
        $stats['score_70_79'] = DocumentCheck::whereBetween('ai_score', [70, 79])->count();
        $stats['score_below_70'] = DocumentCheck::where('ai_score', '<', 70)->count();

        // Recent documents
        $stats['recent_documents'] = DocumentCheck::with(['user', 'template'])
            ->latest()
            ->take(5)
            ->get();

        // Top active students
        $stats['top_students'] = User::where('role', 'mahasiswa')
            ->withCount('documentChecks as documents_count')
            ->having('documents_count', '>', 0)
            ->orderByDesc('documents_count')
            ->take(5)
            ->get();

        // Template usage analytics
        $stats['template_usage'] = Template::withCount('documentChecks')
            ->with(['documentChecks' => function ($query) {
                $query->whereNotNull('ai_score');
            }])
            ->get()
            ->map(function ($template) {
                $checkedDocs = $template->documentChecks;
                $totalChecked = $checkedDocs->count();
                $passedCount = $checkedDocs->where('ai_score', '>=', 70)->count();

                return (object) [
                    'id' => $template->id,
                    'name' => $template->name,
                    'type' => $template->type,
                    'documents_count' => $template->document_checks_count,
                    'total_checked' => $totalChecked,
                    'avg_score' => $totalChecked > 0 ? $checkedDocs->avg('ai_score') : null,
                    'passed_count' => $passedCount,
                ];
            });

        return view('admin.documents.statistics', compact('stats'));
    }

    /**
     * Delete document (admin only)
     */
    public function destroy(DocumentCheck $document)
    {
        try {
            // Delete files
            if (Storage::disk('public')->exists($document->file_path)) {
                Storage::disk('public')->delete($document->file_path);
            }

            if ($document->corrected_file_path && Storage::disk('public')->exists($document->corrected_file_path)) {
                Storage::disk('public')->delete($document->corrected_file_path);
            }

            // Delete record
            $document->delete();

            return back()->with('success', 'Dokumen berhasil dihapus.');
        } catch (\Exception $e) {
            return back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
}
