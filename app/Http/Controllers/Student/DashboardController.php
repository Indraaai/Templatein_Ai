<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\Template;
use App\Models\DocumentCheck;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        // Template sesuai fakultas & prodi mahasiswa
        $templates = Template::where('faculty_id', $user->faculty_id)
            ->where('program_study_id', $user->program_study_id)
            ->where('is_active', true)
            ->with(['faculty', 'programStudy'])
            ->latest()
            ->get();

        // History pengecekan dokumen
        $recentChecks = DocumentCheck::where('user_id', $user->id)
            ->with('template')
            ->latest()
            ->take(5)
            ->get();

        return view('student.dashboard', compact('templates', 'recentChecks', 'user'));
    }
}
