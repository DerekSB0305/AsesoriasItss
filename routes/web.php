<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AdvisoriesController,
    AdvisoryDetailsController,
    Auth\AuthenticatedSessionController,
    ProfileController,
    TeacherAdvisoryReportController,
    TeacherController
};

// Página principal
Route::get('/', fn() => view('welcome'));

// Dashboard
Route::get('/dashboard', fn() => view('dashboard'))
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

// Logout
Route::post('/logout', [AuthenticatedSessionController::class, 'destroy'])
    ->name('logout');


// PERFIL
Route::middleware('auth')->group(function () {
    Route::get('/profile',  [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';


// --------------------------------------------------------------------------
// 📌 RUTAS DEL MÓDULO DE CIENCIAS BÁSICAS
// --------------------------------------------------------------------------
Route::prefix('basic_sciences')
    ->name('basic_sciences.')
    ->middleware(['auth','verified'])
    ->group(function () {

    Route::get('/', fn() => view('basic_sciences.index'))->name('index');

    Route::resource('teachers', \App\Http\Controllers\TeacherController::class);
    Route::resource('students', \App\Http\Controllers\StudentController::class);
    Route::resource('administratives', \App\Http\Controllers\AdministrativeController::class);
    Route::resource('requests', \App\Http\Controllers\RequestsController::class);
    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::resource('teacher_subjects', \App\Http\Controllers\TeacherSubjectController::class);
    Route::resource('advisory_details', AdvisoryDetailsController::class);
    Route::resource('advisories', AdvisoriesController::class);

    Route::get('/advisory_details/students/{subject_id}',
        [AdvisoryDetailsController::class, 'getStudentsBySubject'])
        ->name('advisory_details.getStudents');

    Route::get('advisories/{id}/details',
        [AdvisoriesController::class, 'details'])
        ->name('advisories.details');
});


// --------------------------------------------------------------------------
// 📌 RUTAS DEL MAESTRO
// --------------------------------------------------------------------------
Route::prefix('teachers')
    ->name('teachers.')
    ->middleware(['auth','verified'])
    ->group(function () {

    // Dashboard del maestro
    Route::get('/', [TeacherController::class, 'indexTeacher'])->name('index');

    // ---- Estudiantes ----
    Route::get('students', [\App\Http\Controllers\StudentController::class, 'indexTeacher'])
        ->name('students.index');

    Route::resource('students', \App\Http\Controllers\StudentController::class)
        ->except(['index'])
        ->names('students');

    // ---- Solicitudes ----
    Route::get('requests', [\App\Http\Controllers\RequestsController::class, 'indexTeacher'])
        ->name('requests.index');

    Route::resource('requests', \App\Http\Controllers\RequestsController::class)
        ->except(['index'])
        ->names('requests');

    // ---- Asesorías ----
    Route::get('advisories', [TeacherController::class, 'myAdvisories'])
        ->name('advisories.index');

    // Crear reporte
    Route::get('advisories/{id}/reports/create',
        [TeacherAdvisoryReportController::class, 'create'])
        ->name('advisories.reports.create');

    // Guardar reporte
    Route::post('advisories/{id}/reports',
        [TeacherAdvisoryReportController::class, 'store'])
        ->name('advisories.reports.store');

    // Ver TODOS los reportes del maestro
    Route::get('reports',
        [TeacherAdvisoryReportController::class, 'index'])
        ->name('advisories.reports.index');

    // Ver reportes por asesoría (by_advisory.blade.php)
    Route::get('advisories/{id}/reports',
        [TeacherAdvisoryReportController::class, 'listByAdvisory'])
        ->name('advisories.reports.by_advisory');

    // Editar reporte
    Route::get('advisories/reports/{id}/edit',
        [TeacherAdvisoryReportController::class, 'edit'])
        ->name('advisories.reports.edit');

    // Actualizar reporte
    Route::put('advisories/reports/{id}',
        [TeacherAdvisoryReportController::class, 'update'])
        ->name('advisories.reports.update');

    // Eliminar reporte
    Route::delete('advisories/reports/{id}',
        [TeacherAdvisoryReportController::class, 'destroy'])
        ->name('advisories.reports.destroy');
});
