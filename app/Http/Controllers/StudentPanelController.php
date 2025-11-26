<?php

namespace App\Http\Controllers;

use App\Models\Advisories;
use App\Models\Manual;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class StudentPanelController extends Controller
{
    /**
     * Panel principal del alumno
     */
    public function index()
    {
        $student = Auth::user()->student;

        if (!$student) abort(403);

        $isDefaultPassword = Hash::check($student->enrollment, Auth::user()->password);

        return view('students.panel.index', compact('student', 'isDefaultPassword'));
    }

    /**
     * Ver horario PDF del alumno
     */
    public function schedule()
    {
        $student = Auth::user()->student;
        if (!$student) abort(403);

        return view('students.panel.schedule', compact('student'));
    }

    /**
     * Ver asesorías donde el alumno está inscrito
     */
    public function advisories()
{
    // 🔥 Actualizar asesorías vencidas ANTES de ver las del estudiante
    $hoy = now()->toDateString();

    $asesoriasVencidas = Advisories::where('end_date', '<', $hoy)
        ->whereHas('advisoryDetail', function ($q) {
            $q->where('status', 'Aprobado');
        })
        ->get();

    foreach ($asesoriasVencidas as $item) {
        $item->advisoryDetail->update([
            'status' => 'Finalizado'
        ]);
    }

    $student = Auth::user()->student;

    if (!$student) {
        abort(403);
    }

    $studentEnrollment = $student->enrollment;

    $advisories = Advisories::whereHas('advisoryDetail.students', function ($q) use ($studentEnrollment) {
            $q->where('advisory_detail_student.enrollment', $studentEnrollment);
        })
        ->with([
            'teacherSubject.subject',
            'teacherSubject.teacher',
            'advisoryDetail'
        ])
        ->orderBy('start_date', 'ASC')   // 📌 ORDENAR POR FECHA DE INICIO
        ->orderBy('day_of_week', 'ASC')  // 📌 SEGUNDO ORDEN POR DÍA
        ->orderBy('start_time', 'ASC')   // 📌 TERCERO POR HORA DE INICIO
        ->get();

    return view('students.panel.advisories', compact('student', 'advisories'));
}


    /**
     * 📘 Manuales con buscador + filtros avanzados
     */
    public function manuals(Request $request)
    {
        $student = Auth::user()->student;
        if (!$student) abort(403);

        // 🔎 Parámetros del filtro
        $search        = $request->q;
        $filterSubject = $request->subject;
        $filterTeacher = $request->teacher;

        // Query base — manuales solo de su carrera
        $query = Manual::with(['teacherSubject.subject', 'teacherSubject.teacher'])
            ->whereHas('teacherSubject', function ($q) use ($student) {
                $q->where('career_id', $student->career_id);
            });

        // 🔎 Buscador general
        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'LIKE', "%$search%")
                  ->orWhereHas('teacherSubject.subject', function ($s) use ($search) {
                      $s->where('name', 'LIKE', "%$search%");
                  });
            });
        }

        // 📘 Filtro por materia
        if ($filterSubject) {
            $query->whereHas('teacherSubject', function ($q) use ($filterSubject) {
                $q->where('subject_id', $filterSubject);
            });
        }

        // 👨‍🏫 Filtro por maestro
        if ($filterTeacher) {
            $query->whereHas('teacherSubject', function ($q) use ($filterTeacher) {
                $q->where('teacher_user', $filterTeacher);
            });
        }

        // Resultado final
        $manuals = $query->orderBy('created_at', 'desc')->get();

        // Materias disponibles para filtros
        $availableSubjects = Manual::whereHas('teacherSubject', function ($q) use ($student) {
            $q->where('career_id', $student->career_id);
        })
        ->with('teacherSubject.subject')
        ->get()
        ->pluck('teacherSubject.subject')
        ->unique('subject_id');

        // Maestros disponibles para filtros
        $availableTeachers = Manual::whereHas('teacherSubject', function ($q) use ($student) {
            $q->where('career_id', $student->career_id);
        })
        ->with('teacherSubject.teacher')
        ->get()
        ->pluck('teacherSubject.teacher')
        ->unique('teacher_user');

        return view('students.panel.manuals', compact(
            'student',
            'manuals',
            'availableSubjects',
            'availableTeachers',
            'search',
            'filterSubject',
            'filterTeacher'
        ));
    }

        public function notifications()
    {
        $user = Auth::user();

        $user->unreadNotifications->markAsRead();

        return view('students.notifications.index');
    }


    /**
     * Form para cambiar contraseña
     */
    public function showChangePasswordForm()
    {
        return view('students.panel.change_password');
    }

    /**
     * Actualizar contraseña
     */
    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('students.panel.index')
            ->with('success', 'Contraseña actualizada correctamente.');
    }
}
