<?php

namespace App\Http\Controllers;

use App\Models\Advisories;
use App\Models\Career;
use App\Models\Teacher;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class TeacherController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $search  = $request->search;
        $tutor   = $request->tutor;
        $science = $request->science;
        $degree  = $request->degree;

        $teachers = Teacher::with('career')
            ->when($search, function ($q) use ($search) {
                $q->where(function ($q2) use ($search) {
                    $q2->where('name', 'like', "%$search%")
                        ->orWhere('last_name_f', 'like', "%$search%")
                        ->orWhere('last_name_m', 'like', "%$search%");
                });
            })
            ->when($tutor !== null && $tutor !== '', function ($q) use ($tutor) {
                $q->where('tutor', $tutor);
            })
            ->when($science !== null && $science !== '', function ($q) use ($science) {
                $q->where('science_department', $science);
            })
            ->when($degree, function ($q) use ($degree) {
                $q->where('degree', 'like', "%$degree%");
            })
            ->orderBy('name', 'ASC')
            ->paginate(10)
            ->appends($request->query());

        return view('basic_sciences.teachers.index', compact(
            'teachers',
            'search',
            'tutor',
            'science',
            'degree'
        ));
    }

    public function create()
    {

        $careers = Career::all();
        return view('basic_sciences.teachers.create', compact('careers'));
    }

    public function store(Request $request)
    {

        $validated = $request->validate([
            'teacher_user' => 'required|string|max:50|unique:teachers,teacher_user',
            'name' => 'required|string|max:50',
            'last_name_f' => 'required|string|max:50',
            'last_name_m' => 'required|string|max:50',
            'career_id' => 'required|exists:careers,career_id',
            'degree' => 'required|string|max:50',
            'tutor' => 'sometimes|boolean',
            'science_department' => 'sometimes|boolean',
            'schedule' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        // Guardar archivo con nombre original
        if ($request->hasFile('schedule')) {
            $file = $request->file('schedule');
            $originalName = $file->getClientOriginalName();

            $path = $file->storeAs('teacher_schedules', $originalName, 'public');
            $validated['schedule'] = $path;
        }

        // Crear usuario maestro
        $user = User::create([
            'user'      => $request->teacher_user,
            'password'  => $request->teacher_user,
            'role_id'   => 3,
        ]);

        Teacher::create($validated);

        return redirect()->route('basic_sciences.teachers.index')
            ->with('success', 'Profesor y usuario creado correctamente.');
    }

    public function show(Teacher $teacher)
    {
        return view('basic_sciences.teachers.show', compact('teacher'));
    }

    public function edit(Teacher $teacher)
    {
        $careers = Career::all();
        return view('basic_sciences.teachers.edit', compact('teacher', 'careers'));
    }

    public function update(Request $request, Teacher $teacher)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:50',
            'last_name_f' => 'required|string|max:50',
            'last_name_m' => 'required|string|max:50',
            'career_id' => 'required|exists:careers,career_id',
            'degree' => 'required|string|max:50',
            'tutor' => 'sometimes|boolean',
            'science_department' => 'sometimes|boolean',
            'schedule' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:2048',
        ]);

        // si se sube un archivo
        if ($request->hasFile('schedule')) {
            if ($teacher->schedule && Storage::disk('public')->exists($teacher->schedule)) {
                Storage::disk('public')->delete($teacher->schedule);
            }

            $file = $request->file('schedule');
            $validated['schedule'] = $file->storeAs(
                'teacher_schedules',
                $file->getClientOriginalName(),
                'public'
            );
        }

        // actualizar maestro
        $teacher->update($validated);

        return redirect()->route('basic_sciences.teachers.index')
            ->with('success', 'Profesor actualizado correctamente.');
    }


    public function destroy(Teacher $teacher)
    {
        //Eliminar archivo de horario
        if ($teacher->schedule && Storage::disk('public')->exists($teacher->schedule)) {
            Storage::disk('public')->delete($teacher->schedule);
        }

        $teacher->delete();
        return redirect()->route('basic_sciences.teachers.index')
            ->with('success', 'Profesor eliminado correctamente.');
    }

    // Modulo Maestro
    public function indexTeacher()
    {
        // Maestro logueado
        $teacher = Auth::user()->teacher;

        return view('teachers.index', compact('teacher'));
    }

    public function myAdvisories()
    {
        // 🔥 Actualizar asesorías vencidas
        $hoy = now()->toDateString();

        $asesoriasVencidas = Advisories::where('end_date', '<', $hoy)
            ->whereHas('advisoryDetail', fn($q) => $q->where('status', 'Aprobado'))
            ->get();

        foreach ($asesoriasVencidas as $item) {
            $item->advisoryDetail->update(['status' => 'Finalizado']);
        }

        $teacherUser = auth()->user()->user;

        $advisories = Advisories::with([
            'teacherSubject.teacher',
            'teacherSubject.subject.career',
            'advisoryDetail.students',
            'advisoryDetail.requests.subject' // << NECESARIO PARA saber la materia solicitada
        ])
            ->whereHas('teacherSubject', fn($q) => $q->where('teacher_user', $teacherUser))
            ->orderBy('start_date', 'ASC')
            ->orderBy('start_time', 'ASC')
            ->get();

        // 🔥 AGREGAR MATERIA SOLICITADA (si existe)
        foreach ($advisories as $adv) {
            $solicitud = optional($adv->advisoryDetail->requests)->first();
            $adv->materiaSolicitada = $solicitud?->subject?->name ?? 'Materia común';
            $adv->carreraSolicitada = $solicitud?->subject?->career->name ?? 'Materia común';
        }

        return view('teachers.advisories.index', compact('advisories'));
    }


    public function showChangePasswordForm()
    {
        return view('teachers.change_password');
    }

    public function changePassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:8|confirmed',
        ]);

        $user = Auth::user();

        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('teachers.index')
            ->with('success', 'Contraseña actualizada correctamente.');
    }

    public function indexCareerHead()
    {
        $admin = Auth::user()->administrative;

        if (!$admin) {
            return back()->withErrors(['error' => 'Tu cuenta no está registrada como Jefe de Carrera.']);
        }

        $careerId = $admin->career_id;

        $query = Teacher::with([
            'career',
            'manuals',
            'advisories.advisoryDetail'
        ])
            ->where('career_id', $careerId);

        if (request('nombre')) {
            $search = request('nombre');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('last_name_f', 'like', "%$search%")
                    ->orWhere('last_name_m', 'like', "%$search%");
            });
        }

        if (request('tutor') !== null && request('tutor') !== '') {
            $query->where('tutor', request('tutor'));
        }

        if (request('cb') !== null && request('cb') !== '') {
            $query->where('science_department', request('cb'));
        }

        $teachers = $query->paginate(10)->withQueryString();

        foreach ($teachers as $t) {
            $t->total_advisories = $t->advisories
                ->filter(function ($adv) {
                    return in_array($adv->advisoryDetail->status, ['Pendiente', 'Aprobado']);
                })
                ->count();

            $t->manuals_count = $t->manuals->count();
        }

        return view('career_head.teachers.index', compact('teachers'));
    }
}
