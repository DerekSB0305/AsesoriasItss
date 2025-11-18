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

        // Solo las materias del maestro
        $manuals = Manual::whereHas('teacherSubject', function ($q) use ($teacherUser) {
            $q->where('teacher_user', $teacherUser);
        })->get();

        return view('teachers.manuals.index', compact('manuals'));
    }

    /**
     * Formulario para subir manual
     */
    public function create($teacher_subject_id)
    {
        $teacherSubject = TeacherSubject::findOrFail($teacher_subject_id);

        // Validar acceso del maestro a la materia
        $this->authorizeTeacherSubject($teacherSubject);

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

        $request->validate([
            'title' => 'required|string|max:150',
            'file'  => 'required|file|mimes:pdf,doc,docx,ppt,pptx|max:5120', // 5MB
        ]);

        // Subida del archivo
        $file = $request->file('file');
        $origName = $file->getClientOriginalName();
        $filename = $origName;
        $dir = "manuals";

        // Evitar conflictos de nombres
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
     * Función para validar que el maestro de ciencias básicas tenga acceso
     */
    private function authorizeTeacherSubject($teacherSubject)
    {
        $teacher = Auth::user()->teacher;

        // 1. Verificar que es de ciencias básicas
        if (!$teacher->science_department) {
            abort(403, 'No tienes permisos para subir manuales.');
        }

        // 2. Verificar que la materia sí pertenece al maestro logueado
        if ($teacherSubject->teacher_user !== $teacher->teacher_user) {
            abort(403, 'No puedes subir manuales de materias que no impartes.');
        }
    }
}
