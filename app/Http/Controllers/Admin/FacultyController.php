<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faculty;
use Illuminate\Http\Request;

class FacultyController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faculties = Faculty::withCount('programStudies')
            ->latest()
            ->paginate(10);

        return view('admin.faculties.index', compact('faculties'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.faculties.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:faculties,name'],
        ]);

        Faculty::create($validated);

        return redirect()
            ->route('admin.faculties.index')
            ->with('success', 'Fakultas berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Faculty $faculty)
    {
        $faculty->load('programStudies', 'users');

        return view('admin.faculties.show', compact('faculty'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Faculty $faculty)
    {
        return view('admin.faculties.edit', compact('faculty'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Faculty $faculty)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:faculties,name,' . $faculty->id],
        ]);

        $faculty->update($validated);

        return redirect()
            ->route('admin.faculties.index')
            ->with('success', 'Fakultas berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Faculty $faculty)
    {
        // Check if faculty has program studies
        if ($faculty->programStudies()->count() > 0) {
            return redirect()
                ->route('admin.faculties.index')
                ->with('error', 'Fakultas tidak dapat dihapus karena masih memiliki program studi!');
        }

        // Check if faculty has users
        if ($faculty->users()->count() > 0) {
            return redirect()
                ->route('admin.faculties.index')
                ->with('error', 'Fakultas tidak dapat dihapus karena masih memiliki mahasiswa!');
        }

        $faculty->delete();

        return redirect()
            ->route('admin.faculties.index')
            ->with('success', 'Fakultas berhasil dihapus!');
    }
}
