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
            'template_rules' => 'required|json',
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
            // Create template
            $template = Template::create([
                'name' => $validated['name'],
                'type' => $validated['type'],
                'faculty_id' => $validated['faculty_id'],
                'program_study_id' => $validated['program_study_id'] ?? null,
                'description' => $validated['description'] ?? null,
                'template_rules' => $validated['template_rules'],
                'is_active' => $request->boolean('is_active', true),
            ]);

            // Generate document
            $filePath = $this->generatorService->generateDocument($template);

            // Update template with file path
            $template->update([
                'template_file' => $filePath,
            ]);

            DB::commit();

            return redirect()->route('admin.templates.show', $template)
                ->with('success', 'Template berhasil dibuat dan dokumen telah digenerate.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withErrors(['error' => 'Gagal membuat template: ' . $e->getMessage()])->withInput();
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
        if (!$template->template_file || !Storage::exists($template->template_file)) {
            return back()->with('error', 'File template tidak ditemukan.');
        }

        // Increment download count
        $template->increment('download_count');

        $filename = str_replace(' ', '_', $template->name) . '.docx';

        return Storage::download($template->template_file, $filename);
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

    /**
     * Get program studies by faculty (AJAX)
     */
    public function getProgramStudiesByFaculty(Request $request, $facultyId)
    {
        $programStudies = ProgramStudy::where('faculty_id', $facultyId)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json($programStudies);
    }
}
