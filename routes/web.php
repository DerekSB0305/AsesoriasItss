<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    AdministrativeController,
    AdvisoriesController,
    AdvisoryDetailsController,
    Auth\AuthenticatedSessionController,
    DocumentController,
    ManualController,
    ProfileController,
    StudentController,
    StudentPanelController,
    TeacherAdvisoryReportController,
    TeacherController
};
use Dom\Document;

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

// Ciencias Basicas
require __DIR__ . '/auth.php';

Route::prefix('basic_sciences')
    ->name('basic_sciences.')
    ->middleware(['auth', 'verified'])
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

        Route::get(
            '/advisory_details/students/{subject_id}',
            [AdvisoryDetailsController::class, 'getStudentsBySubject']
        )
            ->name('advisory_details.getStudents');

        Route::get(
            'advisories/{id}/details',
            [AdvisoriesController::class, 'details']
        )
            ->name('advisories.details');

        Route::get('manuals/index', [ManualController::class, 'listManuals'])
            ->name('manuals.index');

        Route::resource('documents', DocumentController::class);
    });

// Jefes de carrera
Route::prefix('career_head')
    ->name('career_head.')
    ->middleware(['auth', 'verified'])
    ->group(function () {

        Route::get('/', [AdministrativeController::class, 'indexCareerHead'])->name('index');

        Route::get('/career_head/change-password', function () {
            return view('career_head.change_password');
        })->name('change_password');

        Route::get('/change-password', [AdministrativeController::class, 'changePasswordForm'])
            ->name('change_password.form');

        Route::post('/change-password', [AdministrativeController::class, 'changePasswordUpdate'])
            ->name('change_password.update');



        Route::get('/teachers', [TeacherController::class, 'indexCareerHead'])->name('teachers.index');
        Route::get('/students', [StudentController::class, 'indexCareerHead'])->name('students.index');
        Route::get('/manuals', [ManualController::class, 'indexCareerHead'])->name('manuals.index');
        Route::get('/advisories', [AdvisoriesController::class, 'indexCareerHead'])->name('advisories.index');
        Route::get('advisories/{id}/details', [AdvisoriesController::class, 'detailsCareerHead'])->name('advisories.details');
    });



// --------------------------------------------------------------------------
// 📌 RUTAS DEL MAESTRO
// --------------------------------------------------------------------------
Route::prefix('teachers')
    ->name('teachers.')
    ->middleware(['auth', 'verified'])
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
        Route::get(
            'advisories/{id}/reports/create',
            [TeacherAdvisoryReportController::class, 'create']
        )
            ->name('advisories.reports.create');

        // Guardar reporte
        Route::post(
            'advisories/{id}/reports',
            [TeacherAdvisoryReportController::class, 'store']
        )
            ->name('advisories.reports.store');

        // Ver TODOS los reportes del maestro
        Route::get(
            'reports',
            [TeacherAdvisoryReportController::class, 'index']
        )
            ->name('advisories.reports.index');

        // Ver reportes por asesoría (by_advisory.blade.php)
        Route::get(
            'advisories/{id}/reports',
            [TeacherAdvisoryReportController::class, 'listByAdvisory']
        )
            ->name('advisories.reports.by_advisory');

        // Editar reporte
        Route::get(
            'advisories/reports/{id}/edit',
            [TeacherAdvisoryReportController::class, 'edit']
        )
            ->name('advisories.reports.edit');

        // Actualizar reporte
        Route::put(
            'advisories/reports/{id}',
            [TeacherAdvisoryReportController::class, 'update']
        )
            ->name('advisories.reports.update');

        // Eliminar reporte
        Route::delete(
            'advisories/reports/{id}',
            [TeacherAdvisoryReportController::class, 'destroy']
        )
            ->name('advisories.reports.destroy');

        // SUBIR MANUALES (solo ciencias básicas)
        Route::get('manuals', [ManualController::class, 'index'])
            ->name('manuals.index');

        Route::get('manuals/create/{teacher_subject}', [ManualController::class, 'create'])
            ->name('manuals.create');

        Route::post('manuals/store/{teacher_subject}', [ManualController::class, 'store'])
            ->name('manuals.store');

        Route::delete('manuals/{manual}', [ManualController::class, 'destroy'])
            ->name('manuals.destroy');

        Route::get('manuals/select/subject', [ManualController::class, 'selectSubject'])
            ->name('manuals.select_subject');
    });

//Cambiar contraseña
Route::get('/teacher/change-password', [TeacherController::class, 'showChangePasswordForm'])
    ->name('password.change.form')
    ->middleware('auth');

Route::post('/teacher/change-password', [TeacherController::class, 'changePassword'])
    ->name('password.change')
    ->middleware('auth');

//Vistas y rutas del módulo del alumno

Route::prefix('students')
    ->name('students.')
    ->middleware(['auth', 'verified'])
    ->group(function () {

        // Panel principal
        Route::get('/', [StudentPanelController::class, 'index'])
            ->name('panel.index');

        // Horario
        Route::get('/schedule', [StudentPanelController::class, 'schedule'])
            ->name('panel.schedule');

        // Asesorías asignadas
        Route::get('/advisories', [StudentPanelController::class, 'advisories'])
            ->name('panel.advisories');

        // Manuales
        Route::get('/manuals', [StudentPanelController::class, 'manuals'])
            ->name('panel.manuals');

        // Cambiar contraseña
        Route::get('/change-password', [StudentPanelController::class, 'showChangePasswordForm'])
            ->name('panel.change_password_form');

        Route::post('/change-password', [StudentPanelController::class, 'changePassword'])
            ->name('panel.change_password');
    });
