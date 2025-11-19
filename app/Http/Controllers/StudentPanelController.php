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
        $student = Auth::user()->student;
        $studentEnrollment = $student->enrollment;

        $advisories = \App\Models\Advisories::whereHas('advisoryDetail.students', function ($q) use ($studentEnrollment) {
            $q->where('advisory_detail_student.enrollment', $studentEnrollment);
        })
        ->with([
            'teacherSubject.subject',
            'teacherSubject.teacher',
            'advisoryDetail'
        ])
        ->orderBy('schedule', 'ASC')
        ->get();

        return view('students.panel.advisories', compact('student', 'advisories'));
    }

    /**
     * Ver manuales según su carrera
     */
    public function manuals()
    {
        $student = Auth::user()->student;

        if (!$student) abort(403);

        $manuals = Manual::whereHas('teacherSubject', function ($q) use ($student) {
            $q->where('career_id', $student->career_id);
        })
        ->with(['teacherSubject.subject', 'teacherSubject.teacher'])
        ->get();

        return view('students.panel.manuals', compact('student', 'manuals'));
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
