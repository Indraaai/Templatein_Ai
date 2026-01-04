<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Template;
use App\Models\Faculty;
use App\Models\ProgramStudy;
use App\Services\TemplateGeneratorService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TemplateController extends Controller
{
    protected TemplateGeneratorService $generatorService;

    public function __construct(TemplateGeneratorService $generatorService)
    {
        $this->generatorService = $generatorService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Template::with(['faculty', 'programStudy']);

        // Filter by faculty
        if ($request->filled('faculty_id')) {
            $query->where('faculty_id', $request->faculty_id);
        }

        // Filter by program study
        if ($request->filled('program_study_id')) {
            $query->where('program_study_id', $request->program_study_id);
        }

        // Filter by type
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Filter by status
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        // Search
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        $templates = $query->latest()->paginate(10);
        $faculties = Faculty::orderBy('name')->get();

        // Stats
        $stats = [
            'total' => Template::count(),
            'active' => Template::where('is_active', true)->count(),
            'inactive' => Template::where('is_active', false)->count(),
            'downloads' => Template::sum('download_count'),
        ];

        return view('admin.templates.index', compact('templates', 'faculties', 'stats'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $faculties = Faculty::orderBy('name')->get();
        $programStudies = ProgramStudy::orderBy('name')->get();

        // Get sample rules for reference
        $sampleRules = TemplateGeneratorService::getSampleRules();

        return view('admin.templates.create', compact('faculties', 'programStudies', 'sampleRules'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:skripsi,proposal,tugas_akhir,laporan_praktikum,makalah,lainnya',
            'faculty_id' => 'required|exists:faculties,id',
            'program_study_id' => 'nullable|exists:program_studies,id',
            'description' => 'nullable|string',
            'is_active' => 'boolean',
        ]);

        // Verify program study belongs to faculty if provided
        if ($request->program_study_id) {
            $programStudy = ProgramStudy::find($request->program_study_id);
            if ($programStudy->faculty_id != $request->faculty_id) {
                return back()->withErrors(['program_study_id' => 'Program studi tidak sesuai dengan fakultas.'])->withInput();
            }
        }

        DB::beginTransaction();
        try {
            // Create template with default rules
            $defaultRules = json_encode([
                'formatting' => [
                    'font' => [
                        'name' => 'Times New Roman',
                        'size' => 12,
                        'line_spacing' => 1.5
                    ],
                    'page_size' => 'A4',
                    'orientation' => 'portrait',
                    'margins' => [
                        'top' => 3,
                        'bottom' => 3,
                        'left' => 4,
                        'right' => 3
                    ]
                ],
                'sections' => []
            ]);

            $template = Template::create([
                'name' => $validated['name'],
                'type' => $validated['type'],
                'faculty_id' => $validated['faculty_id'],
                'program_study_id' => $validated['program_study_id'] ?? null,
                'description' => $validated['description'] ?? null,
                'template_rules' => $defaultRules,
                'is_active' => $request->boolean('is_active', false), // Default inactive until builder is completed
            ]);

            DB::commit();

            return redirect()->route('admin.templates.builder', $template)
                ->with('success', 'Template berhasil dibuat. Silakan lengkapi struktur template.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal membuat template: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Show template builder page
     */
    public function builder(Template $template)
    {
        // Use the refactored modular builder view
        return view('admin.templates.builder', compact('template'));
    }

    /**
     * Save template builder
     */
    public function saveBuilder(Request $request, Template $template)
    {
        // Validate basic structure
        $validated = $request->validate([
            'template_rules' => 'required|json',
            'is_active' => 'boolean',
        ]);

        // Decode and validate template rules structure
        $rules = json_decode($validated['template_rules'], true);

        if (!$rules) {
            return response()->json([
                'success' => false,
                'message' => 'Format JSON tidak valid.'
            ], 422);
        }

        // Validate using TemplateRulesParser
        $parser = app(\App\Services\TemplateRulesParser::class);
        $validation = $parser->validate($rules);

        if (!$validation['valid']) {
            return response()->json([
                'success' => false,
                'message' => 'Struktur template tidak valid.',
                'errors' => $validation['errors']
            ], 422);
        }

        DB::beginTransaction();
        try {
            // Update template rules first
            $template->update([
                'template_rules' => $validated['template_rules'],
                'is_active' => false, // Keep inactive until document generated successfully
            ]);

            // Try to generate document
            try {
                // Delete old file if exists
                if ($template->template_file && Storage::exists($template->template_file)) {
                    Storage::delete($template->template_file);
                }

                $filePath = $this->generatorService->generateDocument($template);

                // Update with file and active status
                $template->update([
                    'template_file' => $filePath,
                    'is_active' => $request->boolean('is_active', false),
                ]);

                DB::commit();

                return response()->json([
                    'success' => true,
                    'message' => 'Template berhasil disimpan dan dokumen telah digenerate.',
                    'redirect' => route('admin.templates.show', $template)
                ]);
            } catch (\Exception $generateError) {
                // Document generation failed, but rules are saved
                Log::error('Template document generation failed', [
                    'template_id' => $template->id,
                    'error' => $generateError->getMessage(),
                    'trace' => $generateError->getTraceAsString()
                ]);

                DB::commit(); // Commit the rules save

                return response()->json([
                    'success' => false,
                    'message' => 'Template rules tersimpan, tetapi gagal generate dokumen.',
                    'error_detail' => $generateError->getMessage(),
                    'saved_rules' => true
                ], 500);
            }
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Template save failed', [
                'template_id' => $template->id,
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Gagal menyimpan template: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Template $template)
    {
        $template->load(['faculty', 'programStudy', 'documentChecks']);

        // Parse rules for display
        $rules = json_decode($template->template_rules, true);

        return view('admin.templates.show', compact('template', 'rules'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Template $template)
    {
        $faculties = Faculty::orderBy('name')->get();
        $programStudies = ProgramStudy::orderBy('name')->get();

        // Parse current rules
        $currentRules = json_decode($template->template_rules, true);

        return view('admin.templates.edit', compact('template', 'faculties', 'programStudies', 'currentRules'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Template $template)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:skripsi,proposal,tugas_akhir,laporan_praktikum,makalah,lainnya',
            'faculty_id' => 'required|exists:faculties,id',
            'program_study_id' => 'nullable|exists:program_studies,id',
            'description' => 'nullable|string',
            'template_rules' => 'required|json',
            'is_active' => 'boolean',
            'regenerate' => 'boolean',
        ]);

        // Verify program study belongs to faculty if provided
        if ($request->program_study_id) {
            $programStudy = ProgramStudy::find($request->program_study_id);
            if ($programStudy->faculty_id != $request->faculty_id) {
                return back()->withErrors(['program_study_id' => 'Program studi tidak sesuai dengan fakultas.'])->withInput();
            }
        }

        DB::beginTransaction();
        try {
            // Update template
            $template->update([
                'name' => $validated['name'],
                'type' => $validated['type'],
                'faculty_id' => $validated['faculty_id'],
                'program_study_id' => $validated['program_study_id'] ?? null,
                'description' => $validated['description'] ?? null,
                'template_rules' => $validated['template_rules'],
                'is_active' => $request->boolean('is_active', true),
            ]);

            // Regenerate document if requested or rules changed
            if ($request->boolean('regenerate') || $template->wasChanged('template_rules')) {
                // Delete old file
                if ($template->template_file && Storage::exists($template->template_file)) {
                    Storage::delete($template->template_file);
                }

                // Generate new document
                $filePath = $this->generatorService->generateDocument($template);

                // Update template with new file path
                $template->update([
                    'template_file' => $filePath,
                ]);
            }

            DB::commit();

            return redirect()->route('admin.templates.show', $template)
                ->with('success', 'Template berhasil diupdate.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal mengupdate template: ' . $e->getMessage()])->withInput();
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Template $template)
    {
        // Check if template has been downloaded
        if ($template->download_count > 0) {
            return back()->with('warning', 'Template ini tidak dapat dihapus karena sudah pernah diunduh.');
        }

        // Check if template has document checks
        if ($template->documentChecks()->count() > 0) {
            return back()->with('warning', 'Template ini tidak dapat dihapus karena memiliki riwayat pemeriksaan dokumen.');
        }

        // Delete file
        if ($template->template_file && Storage::exists($template->template_file)) {
            Storage::delete($template->template_file);
        }

        $template->delete();

        return redirect()->route('admin.templates.index')
            ->with('success', 'Template berhasil dihapus.');
    }

    /**
     * Download template file
     */
    public function download(Template $template)
    {
        // Validasi: pastikan file ada
        if (!$template->template_file || !Storage::disk('public')->exists($template->template_file)) {
            return back()->with('error', 'File template tidak ditemukan.');
        }

        // Increment download count
        $template->incrementDownload();

        // Download file
        $filePath = Storage::disk('public')->path($template->template_file);
        $fileName = $template->name . '.docx';

        return response()->download($filePath, $fileName);
    }

    /**
     * Preview template file
     */
    public function preview(Template $template)
    {
        // Validasi: pastikan file ada
        if (!$template->template_file || !Storage::disk('public')->exists($template->template_file)) {
            abort(404, 'File template tidak ditemukan.');
        }

        // Return file untuk preview di browser
        return response()->file(
            Storage::disk('public')->path($template->template_file)
        );
    }

    /**
     * Regenerate template document
     */
    public function regenerate(Template $template)
    {
        try {
            // Delete old file
            if ($template->template_file && Storage::exists($template->template_file)) {
                Storage::delete($template->template_file);
            }

            // Generate new document
            $filePath = $this->generatorService->generateDocument($template);

            // Update template with new file path
            $template->update([
                'template_file' => $filePath,
            ]);

            return back()->with('success', 'Dokumen template berhasil digenerate ulang.');
        } catch (\Exception $e) {
            return back()->with('error', 'Gagal generate ulang dokumen: ' . $e->getMessage());
        }
    }

    /**
     * Toggle template active status
     */
    public function toggleActive(Template $template)
    {
        $template->update([
            'is_active' => !$template->is_active,
        ]);

        $status = $template->is_active ? 'diaktifkan' : 'dinonaktifkan';

        return back()->with('success', "Template berhasil {$status}.");
    }
}
