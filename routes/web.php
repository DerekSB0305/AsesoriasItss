<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::resource('departments', \App\Http\Controllers\DepartmentController::class)->middleware('auth', 'verified');
require __DIR__.'/auth.php';

Route::resource('teachers', \App\Http\Controllers\TeacherController::class)->middleware('auth', 'verified');
require __DIR__.'/auth.php';

Route::resource('administratives', \App\Http\Controllers\AdministrativeController::class)->middleware('auth', 'verified');
require __DIR__.'/auth.php';

Route::resource('students', \App\Http\Controllers\StudentController::class)->middleware('auth', 'verified');
require __DIR__.'/auth.php';

Route::resource('subjects', \App\Http\Controllers\SubjectController::class)->middleware('auth', 'verified');
require __DIR__.'/auth.php';

Route::resource('teacher_subjects', \App\Http\Controllers\TeacherSubjectController::class)->middleware('auth', 'verified');
require __DIR__.'/auth.php';