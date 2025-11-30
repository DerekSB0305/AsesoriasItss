<?php

namespace App\Http\Controllers;

use App\Models\Requests;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class RequestsController extends Controller
{
    // Index ciencias basicas 
    public function index(Request $request)
    {
        $query = Requests::with(['student.career', 'subject', 'teacher']);

        if ($request->filled('matricula')) {
            $query->whereHas('student', function ($q) use ($request) {
                $q->where('enrollment', 'like', "%{$request->matricula}%");
            });
        }

        if ($request->filled('materia')) {
            $query->whereHas('subject', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->materia}%");
            });
        }

        if ($request->filled('carrera')) {
            $query->whereHas('student.career', function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->carrera}%");
            });
        }

        $requests = $query->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('basic_sciences.requests.index', compact('requests'));
    }



    public function indexTeacher()
    {
        $teacher_user = Auth::user()->teacher->teacher_user;

        $requests = Requests::where('teacher_user', $teacher_user)
            ->with(['student', 'subject'])
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        return view('teachers.requests.index', compact('requests'));
    }


    public function create()
    {
        $teacher_user = Auth::user()->teacher->teacher_user;

        $students = Student::where('teacher_user', $teacher_user)->get();
        $subjects = Subject::all();

        return view('teachers.requests.create', compact('students', 'subjects'));
    }


    /**
     * ===========================================
     * STORE — Archivo compartido y nombre maestro
     * ===========================================
     */
    public function store(Request $request)
    {
        $request->validate([
            'enrollments'   => ['required', 'array'],
            'enrollments.*' => ['string', 'exists:students,enrollment'],

            'subject_id'    => ['required', 'integer', 'exists:subjects,subject_id'],
            'reason'        => ['nullable', 'string', 'max:500'],

            'canalization_file' => ['nullable', 'file', 'mimes:pdf,doc,docx,jpg,jpeg,png', 'max:2048'],
        ]);

        $teacher = Auth::user()->teacher;

        if (!$teacher) {
            abort(403, "Solo los docentes pueden crear solicitudes.");
        }

        $filePath = null;

        /**
         * ==========================================================
         * 1) GUARDAR ARCHIVO UNA SOLA VEZ (nombre = teacher_user)
         * ==========================================================
         */
        if ($request->hasFile('canalization_file')) {

            $file = $request->file('canalization_file');
            $ext = $file->getClientOriginalExtension();

            // Nombre base con el usuario del maestro
            $baseName = $teacher->teacher_user . "_canalizacion";

            $folder = "canalizations";

            // Evitar duplicados
            $finalName = $this->avoidDuplicateNames($folder, $baseName, $ext);

            // Guardar solo UNA VEZ
            $filePath = $file->storeAs($folder, $finalName, 'public');
        }

        /**
         * ==========================================================
         * 2) CREAR UNA SOLICITUD POR ALUMNO
         * ==========================================================
         */
        foreach ($request->enrollments as $enrollment) {
            Requests::create([
                'enrollment'        => $enrollment,
                'teacher_user'      => $teacher->teacher_user,
                'subject_id'        => $request->subject_id,
                'reason'            => $request->reason,
                'canalization_file' => $filePath,  // 🔥 TODOS COMPARTEN EL MISMO ARCHIVO
            ]);
        }

        return redirect()
            ->route('teachers.requests.index')
            ->with('success', 'Solicitudes enviadas correctamente.');
    }


    /**
     * ============================================================
     * FUNCIÓN PARA EVITAR NOMBRES REPETIDOS
     * base.ext → base(1).ext → base(2).ext ...
     * ============================================================
     */
    private function avoidDuplicateNames($folder, $baseName, $ext)
    {
        $disk = Storage::disk('public');

        $filename = "$baseName.$ext";
        $counter = 1;

        while ($disk->exists("$folder/$filename")) {
            $filename = $baseName . "($counter)." . $ext;
            $counter++;
        }

        return $filename;
    }
}
