<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Faculty;
use App\Models\ProgramStudy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class StudentController extends Controller
{
    /**
     * Display a listing of students.
     */
    public function index(Request $request)
    {
        $query = User::where('role', 'mahasiswa')
            ->with(['faculty', 'programStudy']);

        // Filter by faculty
        if ($request->filled('faculty_id')) {
            $query->where('faculty_id', $request->faculty_id);
        }

        // Filter by program study
        if ($request->filled('program_study_id')) {
            $query->where('program_study_id', $request->program_study_id);
        }

        // Search by name or email
        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%');
            });
        }

        $students = $query->latest()->paginate(15);
        $faculties = Faculty::orderBy('name')->get();
        $programStudies = ProgramStudy::orderBy('name')->get();

        return view('admin.students.index', compact('students', 'faculties', 'programStudies'));
    }

    /**
     * Show the form for creating a new student.
     */
    public function create()
    {
        $faculties = Faculty::orderBy('name')->get();
        return view('admin.students.create', compact('faculties'));
    }

    /**
     * Store a newly created student in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'faculty_id' => 'required|exists:faculties,id',
            'program_study_id' => 'required|exists:program_studies,id',
        ]);

        // Verify program study belongs to faculty
        $programStudy = ProgramStudy::find($request->program_study_id);
        if (!$programStudy) {
            return back()->withErrors(['program_study_id' => 'Program studi tidak valid.'])->withInput();
        }

        if ($programStudy->faculty_id != $request->faculty_id) {
            return back()->withErrors(['program_study_id' => 'Program studi tidak sesuai dengan fakultas yang dipilih.'])->withInput();
        }

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'mahasiswa',
            'faculty_id' => $validated['faculty_id'],
            'program_study_id' => $validated['program_study_id'],
            'email_verified_at' => now(),
        ]);

        return redirect()->route('admin.students.index')
            ->with('success', 'Mahasiswa berhasil ditambahkan!');
    }

    /**
     * Display the specified student.
     */
    public function show(User $student)
    {
        if ($student->role !== 'mahasiswa') {
            abort(404);
        }

        $student->load(['faculty', 'programStudy', 'documentChecks']);
        return view('admin.students.show', compact('student'));
    }

    /**
     * Show the form for editing the specified student.
     */
    public function edit(User $student)
    {
        if ($student->role !== 'mahasiswa') {
            abort(404);
        }

        $faculties = Faculty::orderBy('name')->get();
        $programStudies = ProgramStudy::where('faculty_id', $student->faculty_id)
            ->orderBy('name')
            ->get();

        return view('admin.students.edit', compact('student', 'faculties', 'programStudies'));
    }

    /**
     * Update the specified student in storage.
     */
    public function update(Request $request, User $student)
    {
        if ($student->role !== 'mahasiswa') {
            abort(404);
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'email', Rule::unique('users')->ignore($student->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'faculty_id' => 'required|exists:faculties,id',
            'program_study_id' => 'required|exists:program_studies,id',
        ]);

        // Verify program study belongs to faculty
        $programStudy = ProgramStudy::find($request->program_study_id);
        if (!$programStudy) {
            return back()->withErrors(['program_study_id' => 'Program studi tidak valid.'])->withInput();
        }

        if ($programStudy->faculty_id != $request->faculty_id) {
            return back()->withErrors(['program_study_id' => 'Program studi tidak sesuai dengan fakultas yang dipilih.'])->withInput();
        }

        $data = [
            'name' => $validated['name'],
            'email' => $validated['email'],
            'faculty_id' => $validated['faculty_id'],
            'program_study_id' => $validated['program_study_id'],
        ];

        // Only update password if provided
        if ($request->filled('password')) {
            $data['password'] = Hash::make($validated['password']);
        }

        $student->update($data);

        return redirect()->route('admin.students.index')
            ->with('success', 'Data mahasiswa berhasil diperbarui!');
    }

    /**
     * Remove the specified student from storage.
     */
    public function destroy(User $student)
    {
        if ($student->role !== 'mahasiswa') {
            abort(404);
        }

        $student->delete();

        return redirect()->route('admin.students.index')
            ->with('success', 'Mahasiswa berhasil dihapus!');
    }

    /**
     * Bulk delete students.
     */
    public function bulkDelete(Request $request)
    {
        $request->validate([
            'student_ids' => 'required|array',
            'student_ids.*' => 'exists:users,id',
        ]);

        User::whereIn('id', $request->student_ids)
            ->where('role', 'mahasiswa')
            ->delete();

        return redirect()->route('admin.students.index')
            ->with('success', count($request->student_ids) . ' mahasiswa berhasil dihapus!');
    }
}
