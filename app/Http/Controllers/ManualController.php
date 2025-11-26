<?php

namespace App\Http\Controllers;

use App\Models\Manual;
use App\Models\TeacherSubject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ManualController extends Controller
{
    /**
     * Listar todos los manuales del maestro
     */
    public function index()
    {
        $teacherUser = Auth::user()->teacher->teacher_user;

        // Solo manuales de materias del maestro
        $manuals = Manual::whereHas('teacherSubject', function ($q) use ($teacherUser) {
            $q->where('teacher_user', $teacherUser);
        })->get();

        return view('teachers.manuals.index', compact('manuals'));
    }

    /**
     * Seleccionar materia para subir manual
     */
    public function selectSubject()
    {
        $teacherUser = Auth::user()->teacher->teacher_user;

        // Todas las materias del maestro
        $subjects = TeacherSubject::with(['subject', 'subject.career'])
            ->where('teacher_user', $teacherUser)
            ->get();

        return view('teachers.manuals.select_subject', compact('subjects'));
    }

    /**
     * Formulario para subir manual
     */
    public function create($teacher_subject_id)
    {
        $teacherSubject = TeacherSubject::findOrFail($teacher_subject_id);

        // Validar que pertenece al maestro
        $this->authorizeTeacherSubject($teacherSubject);

        // RESTRICCIÓN: Solo permitir 1 manual por materia
        $manualExiste = Manual::where('teacher_subject_id', $teacher_subject_id)->exists();

        if ($manualExiste) {
            return redirect()
                ->route('teachers.manuals.index')
                ->with('error', 'Ya existe un manual para esta materia. Solo puedes subir uno.');
        }

        return view('teachers.manuals.create', compact('teacherSubject'));
    }

    /**
     * Guardar manual
     */
    public function store(Request $request, $teacher_subject_id)
    {
        $teacherSubject = TeacherSubject::findOrFail($teacher_subject_id);

        // Validar que la materia pertenece al maestro
        $this->authorizeTeacherSubject($teacherSubject);

        // RESTRICCIÓN: Solo 1 manual por materia
        $manualExiste = Manual::where('teacher_subject_id', $teacher_subject_id)->exists();

        if ($manualExiste) {
            return redirect()
                ->route('teachers.manuals.index')
                ->with('error', 'Esta materia ya tiene un manual registrado.');
        }

        $request->validate([
            'title' => 'required|string|max:150',
            'file'  => 'required|file|mimes:pdf,doc,docx,ppt,pptx|max:5120',
        ]);

        // Subir archivo con nombre original
        $file = $request->file('file');
        $origName = $file->getClientOriginalName();
        $filename = $origName;
        $dir = "manuals";

        // Evitar duplicados en el storage
        $counter = 1;
        while (Storage::disk('public')->exists("$dir/$filename")) {
            $filename = pathinfo($origName, PATHINFO_FILENAME)
                . "_$counter." . $file->getClientOriginalExtension();
            $counter++;
        }

        $path = $file->storeAs($dir, $filename, 'public');

        // Guardar en BD
        Manual::create([
            'teacher_subject_id' => $teacher_subject_id,
            'title'              => $request->title,
            'file_path'          => $path
        ]);

        return redirect()
            ->route('teachers.manuals.index')
            ->with('success', 'Manual subido correctamente.');
    }

    /**
     * Eliminar manual
     */
    public function destroy(Manual $manual)
    {
        // Validar que pertenece al maestro
        $this->authorizeTeacherSubject($manual->teacherSubject);

        // Eliminar archivo físico
        if (Storage::disk('public')->exists($manual->file_path)) {
            Storage::disk('public')->delete($manual->file_path);
        }

        $manual->delete();

        return redirect()
            ->route('teachers.manuals.index')
            ->with('success', 'Manual eliminado correctamente.');
    }

    /**
     * Validar que el maestro pueda acceder
     */
    private function authorizeTeacherSubject($teacherSubject)
    {
        $teacher = Auth::user()->teacher;

        // 1. Debe ser docente de ciencias básicas
        if (!$teacher->science_department) {
            abort(403, 'No tienes permisos para subir manuales.');
        }

        // 2. Debe impartir esa materia
        if ($teacherSubject->teacher_user !== $teacher->teacher_user) {
            abort(403, 'No puedes subir manuales de materias que no impartes.');
        }
    }

    /**
     * Vista para Ciencias Básicas (admin)
     */
    public function listManuals(Request $request)
    {
        $maestro = $request->maestro;
        $materia = $request->materia;

        $manuals = Manual::with([
            'teacherSubject.teacher',
            'teacherSubject.subject.career'
        ])
            ->when($maestro, function ($q) use ($maestro) {
                $q->whereHas('teacherSubject.teacher', function ($t) use ($maestro) {
                    $t->where('name', 'like', "%$maestro%")
                        ->orWhere('last_name_f', 'like', "%$maestro%")
                        ->orWhere('last_name_m', 'like', "%$maestro%");
                });
            })
            ->when($materia, function ($q) use ($materia) {
                $q->whereHas('teacherSubject.subject', function ($s) use ($materia) {
                    $s->where('name', 'like', "%$materia%");
                });
            })
            ->orderBy('created_at', 'desc')
            ->get();

        return view('basic_sciences.manuals.index', compact('manuals'));
    }


    /**
     * Vista para Jefes de Carrera
     */
    public function indexCareerHead()
    {
        $admin = Auth::user()->administrative;

        if (!$admin) {
            return back()->withErrors(['error' => 'Tu cuenta no está registrada como Jefe de Carrera.']);
        }

        $careerId = $admin->career_id;

        $manuals = Manual::with(['teacherSubject.teacher', 'teacherSubject.subject'])
            ->whereHas('teacherSubject.teacher', function ($q) use ($careerId) {
                $q->where('career_id', $careerId);  // 🔥 Maestro pertenece a mi carrera
            })
            ->get();

        return view('career_head.manuals.index', compact('manuals'));
    }
}
