<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Student\DashboardController as StudentDashboardController;
use App\Models\ProgramStudy;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
})->name('home');

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

    // Template Management
    Route::resource('templates', \App\Http\Controllers\Admin\TemplateController::class);
    Route::post('templates/{template}/toggle-active', [\App\Http\Controllers\Admin\TemplateController::class, 'toggleActive'])->name('templates.toggle-active');
    Route::post('templates/{template}/regenerate', [\App\Http\Controllers\Admin\TemplateController::class, 'regenerate'])->name('templates.regenerate');
    Route::get('templates/{template}/download', [\App\Http\Controllers\Admin\TemplateController::class, 'download'])->name('templates.download');

    // Student Management
    Route::resource('students', \App\Http\Controllers\Admin\StudentController::class);
    Route::post('students/bulk-delete', [\App\Http\Controllers\Admin\StudentController::class, 'bulkDelete'])->name('students.bulk-delete');

    // Document Review Management
    Route::get('documents/review', [\App\Http\Controllers\Admin\DocumentReviewController::class, 'index'])->name('documents.index');
    Route::get('documents/review/statistics', [\App\Http\Controllers\Admin\DocumentReviewController::class, 'statistics'])->name('documents.statistics');
    Route::get('documents/review/{document}', [\App\Http\Controllers\Admin\DocumentReviewController::class, 'show'])->name('documents.show');
    Route::post('documents/review/{document}/approve', [\App\Http\Controllers\Admin\DocumentReviewController::class, 'approve'])->name('documents.approve');
    Route::post('documents/review/{document}/reject', [\App\Http\Controllers\Admin\DocumentReviewController::class, 'reject'])->name('documents.reject');
    Route::post('documents/review/{document}/request-revision', [\App\Http\Controllers\Admin\DocumentReviewController::class, 'requestRevision'])->name('documents.request-revision');
    Route::get('documents/review/{document}/download', [\App\Http\Controllers\Admin\DocumentReviewController::class, 'downloadOriginal'])->name('documents.download');
    Route::get('documents/review/{document}/download-corrected', [\App\Http\Controllers\Admin\DocumentReviewController::class, 'downloadCorrected'])->name('documents.download-corrected');
    Route::post('documents/bulk-approve', [\App\Http\Controllers\Admin\DocumentReviewController::class, 'bulkApprove'])->name('documents.bulk-approve');
    Route::delete('documents/review/{document}', [\App\Http\Controllers\Admin\DocumentReviewController::class, 'destroy'])->name('documents.destroy');
});

// Student routes
Route::prefix('student')->middleware(['auth', 'role:mahasiswa'])->name('student.')->group(function () {
    Route::get('/dashboard', [StudentDashboardController::class, 'index'])->name('dashboard');

    // Template routes for students
    Route::get('/templates', [\App\Http\Controllers\Student\TemplateController::class, 'index'])->name('templates.index');
    Route::get('/templates/{template}', [\App\Http\Controllers\Student\TemplateController::class, 'show'])->name('templates.show');
    Route::get('/templates/{template}/download', [\App\Http\Controllers\Student\TemplateController::class, 'download'])->name('templates.download');
    Route::get('/templates/{template}/preview', [\App\Http\Controllers\Student\TemplateController::class, 'preview'])->name('templates.preview');

    // Document Check routes for students
    Route::get('/documents', [\App\Http\Controllers\Student\DocumentCheckController::class, 'index'])->name('documents.index');
    Route::get('/documents/upload', [\App\Http\Controllers\Student\DocumentCheckController::class, 'create'])->name('documents.create');
    Route::post('/documents/upload', [\App\Http\Controllers\Student\DocumentCheckController::class, 'store'])->name('documents.store');
    Route::get('/documents/{document}', [\App\Http\Controllers\Student\DocumentCheckController::class, 'show'])->name('documents.show');
    Route::get('/documents/{document}/download', [\App\Http\Controllers\Student\DocumentCheckController::class, 'downloadOriginal'])->name('documents.download');
    Route::get('/documents/{document}/download-corrected', [\App\Http\Controllers\Student\DocumentCheckController::class, 'downloadCorrected'])->name('documents.download-corrected');
    Route::get('/documents/{document}/download-feedback', [\App\Http\Controllers\Student\DocumentCheckController::class, 'downloadFeedback'])->name('documents.download-feedback');
    Route::post('/documents/{document}/recheck', [\App\Http\Controllers\Student\DocumentCheckController::class, 'recheck'])->name('documents.recheck');
    Route::delete('/documents/{document}', [\App\Http\Controllers\Student\DocumentCheckController::class, 'destroy'])->name('documents.destroy');
});

// API route untuk AJAX loading program studies (accessible by guests and authenticated users)
Route::get('/api/program-studies/{facultyId}', function ($facultyId) {
    return ProgramStudy::where('faculty_id', $facultyId)
        ->orderBy('name')
        ->get(['id', 'name']);
})->name('api.program-studies');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
