<?php

use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});
Route::resource('/administratives', \App\Http\Controllers\AdministrativeController::class)->middleware('auth', 'verified');
require __DIR__.'/auth.php';

Route::prefix('basic_sciences')->name('basic_sciences.')->middleware(['auth','verified'])->group(function(){
    Route::get('/', function () {
        return view('basic_sciences.index');
    })->name('index');

    //Crud
    Route::resource('teachers', \App\Http\Controllers\TeacherController::class);
    Route::resource('students', \App\Http\Controllers\StudentController::class);
    Route::resource('administratives', \App\Http\Controllers\AdministrativeController::class);
    Route::resource('requests', \App\Http\Controllers\RequestsController::class);
    Route::resource('advisory_details', \App\Http\Controllers\AdvisoryDetailsController::class);
    Route::resource('advisories', \App\Http\Controllers\AdvisoriesController::class);
    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::resource('teacher_subjects', \App\Http\Controllers\TeacherSubjectController::class);
});

    // Rutas Maestro //
    Route::prefix('teachers')->name('teachers.')->middleware(['auth','verified'])->group(function () {

    // Inicio Maestro
    Route::get('/', [\App\Http\Controllers\TeacherController::class, 'indexTeacher'])->name('index');

    // sobrescribir INDEX del resource
    Route::get('students', [\App\Http\Controllers\StudentController::class, 'indexTeacher'])
            ->name('students.index');

    // ahora sí el resource pero SIN index
    Route::resource('students', \App\Http\Controllers\StudentController::class)
            ->except(['index'])
            ->names('students');

    // Solicitudes del maestro
        // Solicitudes del maestro

    // sobreescribir INDEX del resource
    Route::get('requests', [\App\Http\Controllers\RequestsController::class, 'indexTeacher'])
        ->name('requests.index');

    // ya después el resource pero sin index
    Route::resource('requests', \App\Http\Controllers\RequestsController::class)
        ->except(['index'])
        ->names('requests');

});

Route::resource('/students', \App\Http\Controllers\StudentController::class)->middleware('auth', 'verified');
require __DIR__.'/auth.php';

Route::resource('subjects', \App\Http\Controllers\SubjectController::class)->middleware('auth', 'verified');
require __DIR__.'/auth.php';

Route::resource('teacher_subjects', \App\Http\Controllers\TeacherSubjectController::class)->middleware('auth', 'verified');
require __DIR__.'/auth.php';
