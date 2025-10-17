<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgramStudy;
use App\Models\Faculty;
use Illuminate\Http\Request;

class ProgramStudyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $programStudies = ProgramStudy::with('faculty')
            ->withCount('users')
            ->latest()
            ->paginate(15);

        return view('admin.program-studies.index', compact('programStudies'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $faculties = Faculty::all();
        return view('admin.program-studies.create', compact('faculties'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'faculty_id' => ['required', 'exists:faculties,id'],
            'name' => ['required', 'string', 'max:255'],
        ]);

        ProgramStudy::create($validated);

        return redirect()
            ->route('admin.program-studies.index')
            ->with('success', 'Program Studi berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(ProgramStudy $programStudy)
    {
        $programStudy->load('faculty', 'users');

        return view('admin.program-studies.show', compact('programStudy'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProgramStudy $programStudy)
    {
        $faculties = Faculty::all();
        return view('admin.program-studies.edit', compact('programStudy', 'faculties'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProgramStudy $programStudy)
    {
        $validated = $request->validate([
            'faculty_id' => ['required', 'exists:faculties,id'],
            'name' => ['required', 'string', 'max:255'],
        ]);

        $programStudy->update($validated);

        return redirect()
            ->route('admin.program-studies.index')
            ->with('success', 'Program Studi berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProgramStudy $programStudy)
    {
        // Check if program study has users
        if ($programStudy->users()->count() > 0) {
            return redirect()
                ->route('admin.program-studies.index')
                ->with('error', 'Program Studi tidak dapat dihapus karena masih memiliki mahasiswa!');
        }

        $programStudy->delete();

        return redirect()
            ->route('admin.program-studies.index')
            ->with('success', 'Program Studi berhasil dihapus!');
    }
}
