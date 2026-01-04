<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class TemplateController extends Controller
{
    /**
     * Display a listing of available templates for the student.
     */
    public function index()
    {
        $user = Auth::user();

        // Get templates sesuai fakultas & prodi mahasiswa yang aktif
        $templates = Template::where('faculty_id', $user->faculty_id)
            ->where('program_study_id', $user->program_study_id)
            ->where('is_active', true)
            ->with(['faculty', 'programStudy'])
            ->latest()
            ->paginate(12);

        return view('student.templates.index', compact('templates'));
    }

    /**
     * Display the specified template.
     */
    public function show(Template $template)
    {
        $user = Auth::user();

        // Validasi: pastikan template sesuai dengan fakultas & prodi mahasiswa
        if (
            $template->faculty_id !== $user->faculty_id ||
            $template->program_study_id !== $user->program_study_id
        ) {
            abort(403, 'Anda tidak memiliki akses ke template ini.');
        }

        // Validasi: pastikan template aktif
        if (!$template->is_active) {
            abort(404, 'Template tidak tersedia.');
        }

        $template->load(['faculty', 'programStudy']);

        return view('student.templates.show', compact('template'));
    }

    /**
     * Download the template file.
     */
    public function download(Template $template)
    {
        $user = Auth::user();

        // Validasi: pastikan template sesuai dengan fakultas & prodi mahasiswa
        if (
            $template->faculty_id !== $user->faculty_id ||
            $template->program_study_id !== $user->program_study_id
        ) {
            abort(403, 'Anda tidak memiliki akses ke template ini.');
        }

        // Validasi: pastikan template aktif
        if (!$template->is_active) {
            abort(404, 'Template tidak tersedia.');
        }

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
     * Preview the template file.
     */
    public function preview(Template $template)
    {
        $user = Auth::user();

        // Validasi: pastikan template sesuai dengan fakultas & prodi mahasiswa
        if (
            $template->faculty_id !== $user->faculty_id ||
            $template->program_study_id !== $user->program_study_id
        ) {
            abort(403, 'Anda tidak memiliki akses ke template ini.');
        }

        // Validasi: pastikan template aktif
        if (!$template->is_active) {
            abort(404, 'Template tidak tersedia.');
        }

        // Validasi: pastikan file ada
        if (!$template->template_file || !Storage::disk('public')->exists($template->template_file)) {
            abort(404, 'File template tidak ditemukan.');
        }

        // Return file untuk preview di browser
        return response()->file(
            Storage::disk('public')->path($template->template_file)
        );
    }
}
