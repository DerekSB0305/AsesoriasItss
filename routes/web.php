<?php

use App\Http\Controllers\AdvisoriesController;
use App\Http\Controllers\AdvisoryDetailsController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TeacherAdvisoryReportController;
use App\Http\Controllers\TeacherController;
use App\Models\Advisories;
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
    Route::resource('users', \App\Http\Controllers\UserController::class);
    Route::resource('teacher_subjects', \App\Http\Controllers\TeacherSubjectController::class);
    Route::resource('advisory_details', AdvisoryDetailsController::class);
    Route::resource('advisories', AdvisoriesController::class);

    // Ruta AJAX para cargar alumnos por materia
    Route::get('/advisory_details/students/{subject_id}',
        [AdvisoryDetailsController::class, 'getStudentsBySubject']
    )->name('advisory_details.getStudents');

    Route::get('advisories/{id}/details',
        [AdvisoriesController::class, 'details'])
        ->name('advisories.details');

    
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

            Route::get('advisories', [TeacherController::class, 'myAdvisories'])
        ->name('advisories.index');

            Route::get('advisories/{id}/reports/create', 
        [TeacherAdvisoryReportController::class, 'create']
            )->name('advisories.reports.create');

        Route::post('advisories/{id}/reports', 
        [TeacherAdvisoryReportController::class, 'store']
            )->name('advisories.reports.store');

            // Listar reportes del maestro
        Route::get('reports', 
            [TeacherAdvisoryReportController::class, 'index'])
            ->name('advisories.reports.index');

            Route::get('advisories/{id}/reports', 
            [TeacherAdvisoryReportController::class, 'listByAdvisory']
            )->name('advisories.reports.index');
        // EDITAR REPORTE
        Route::get('advisories/reports/{id}/edit', 
            [TeacherAdvisoryReportController::class, 'edit'])
            ->name('advisories.reports.edit');

        // ACTUALIZAR REPORTE
        Route::put('advisories/reports/{id}', 
            [TeacherAdvisoryReportController::class, 'update'])
            ->name('advisories.reports.update');

        // ELIMINAR REPORTE
        Route::delete('advisories/reports/{id}',
            [TeacherAdvisoryReportController::class, 'destroy'])
            ->name('advisories.reports.destroy');



});

Route::resource('/students', \App\Http\Controllers\StudentController::class)->middleware('auth', 'verified');
require __DIR__.'/auth.php';

Route::resource('subjects', \App\Http\Controllers\SubjectController::class)->middleware('auth', 'verified');
require __DIR__.'/auth.php';

Route::resource('teacher_subjects', \App\Http\Controllers\TeacherSubjectController::class)->middleware('auth', 'verified');
require __DIR__.'/auth.php';
