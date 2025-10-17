<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Models\ProgramStudy;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Original dashboard route (redirect berdasarkan role)
Route::get('/dashboard', function () {
    $user = auth()->user();
    if ($user->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }
    return redirect()->route('student.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Admin routes
Route::prefix('admin')->middleware(['auth', 'role:admin'])->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');

    // Academic Management
    Route::resource('faculties', \App\Http\Controllers\Admin\FacultyController::class);
    Route::resource('program-studies', \App\Http\Controllers\Admin\ProgramStudyController::class);
});

// Student routes
Route::prefix('student')->middleware(['auth', 'role:mahasiswa'])->name('student.')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');
});

// API route untuk AJAX loading program studies
Route::get('/api/program-studies/{facultyId}', function ($facultyId) {
    return ProgramStudy::where('faculty_id', $facultyId)->get();
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
