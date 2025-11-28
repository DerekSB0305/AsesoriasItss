<?php

namespace App\Http\Controllers;

use App\Models\Advisories;
use App\Models\Advisory_details;
use App\Models\Evaluation;
use App\Models\Requests;
use App\Notifications\AdvisoryCreated;
use App\Notifications\AdvisoryStudentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AdvisoriesController extends Controller
{
    public function index(Request $request)
    {
        // Día actual
        $hoy = now()->toDateString();

        // Actualizar asesorías vencidas
        $asesoriasVencidas = Advisories::where('end_date', '<', $hoy)
            ->whereHas('advisoryDetail', fn($q) => $q->where('status', 'Aprobado'))
            ->get();

        foreach ($asesoriasVencidas as $item) {
            $item->advisoryDetail->update(['status' => 'Finalizado']);
        }

        // Consultar todas las asesorías con la materia solicitada
        $query = Advisories::with([
            'teacherSubject.teacher',
            'teacherSubject.subject', // materia del maestro
            'advisoryDetail',
            'advisoryDetail.requests.subject', // materia SOLICITADA
        ]);

        // Buscador
        if ($request->q) {
            $q = $request->q;

            $query->where(function ($sub) use ($q) {
                $sub->whereHas('teacherSubject.teacher', fn($t) =>
                $t->where('name', 'LIKE', "%$q%"))
                    ->orWhereHas('teacherSubject.subject', fn($s) =>
                    $s->where('name', 'LIKE', "%$q%"))
                    ->orWhereHas('advisoryDetail.requests.subject', fn($s2) =>
                    $s2->where('name', 'LIKE', "%$q%"));
            });
        }

        $advisories = $query->get();

        return view('basic_sciences.advisories.index', compact('advisories'));
    }


    public function create(Request $request)
    {
        $detailId = $request->detail_id;

        if (!$detailId) {
            return redirect()->route('basic_sciences.advisory_details.create')
                ->with('error', 'Primero crea un detalle de asesoría.');
        }

        $detail = Advisory_details::with(['students', 'requests.subject'])->findOrFail($detailId);

        $tutorUsers = Requests::whereIn('enrollment', $detail->students->pluck('enrollment'))
            ->pluck('teacher_user')
            ->toArray();

        $teacherSubjects = \App\Models\TeacherSubject::with(['teacher', 'subject', 'career'])
            ->whereNotIn('teacher_user', $tutorUsers)
            ->get();

        return view('basic_sciences.advisories.create', compact('detail', 'teacherSubjects'));
    }


    public function store(Request $request)
    {
        $today = now()->toDateString();

        $request->validate([
            'advisory_detail_id' => 'required|exists:advisory_details,advisory_detail_id',
            'teacher_subject_id' => 'required|exists:teacher_subjects,teacher_subject_id',
            'start_date'         => "required|date|after_or_equal:$today",
            'end_date'           => 'required|date|after_or_equal:start_date',
            'day_of_week'        => 'required|string',
            'start_time'         => 'required|date_format:H:i',
            'end_time'           => 'required|date_format:H:i|after:start_time',
            'classroom'          => 'nullable|string|max:10',
            'building'           => 'nullable|string|max:10',
            'assignment_file'    => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:4096',
        ]);

        // Validación horario
        if ($request->start_time < "07:00" || $request->end_time > "16:00") {
            return back()->withErrors([
                'start_time' => 'Las asesorías solo pueden ser entre 7:00 AM y 4:00 PM.'
            ]);
        }

        // Conflicto maestro
        $conflictoMaestro = Advisories::where('teacher_subject_id', $request->teacher_subject_id)
            ->where('day_of_week', $request->day_of_week)
            ->where(function ($q) use ($request) {
                $q->where('start_time', '<', $request->end_time)
                    ->where('end_time', '>', $request->start_time);
            })
            ->exists();

        if ($conflictoMaestro) {
            return back()->withErrors([
                'start_time' => 'El maestro ya tiene una asesoría en ese horario.'
            ]);
        }

        // Conflicto aula
        if ($request->classroom) {
            $conflictoAula = Advisories::where('classroom', $request->classroom)
                ->where('day_of_week', $request->day_of_week)
                ->where(function ($q) use ($request) {
                    $q->where('start_time', '<', $request->end_time)
                        ->where('end_time', '>', $request->start_time);
                })
                ->exists();

            if ($conflictoAula) {
                return back()->withErrors(['classroom' => 'El aula ya está ocupada.']);
            }
        }

        // Validación alumno → solo 1 asesoría activa
        $detail = Advisory_details::with(['students'])->find($request->advisory_detail_id);

        foreach ($detail->students as $student) {
            $activa = Advisories::whereHas('advisoryDetail.students', fn($q) =>
            $q->where('students.enrollment', $student->enrollment))
                ->whereHas('advisoryDetail', fn($q) =>
                $q->where('status', 'Aprobado'))
                ->exists();

            if ($activa) {
                return back()->withErrors([
                    'start_time' => "El alumno {$student->name} ({$student->enrollment}) ya tiene una asesoría activa."
                ]);
            }
        }

        // Archivo
        $path = null;
        if ($request->hasFile('assignment_file')) {
            $file = $request->file('assignment_file');
            $path = $file->storeAs('assignments', $file->getClientOriginalName(), 'public');
        }

        // Crear asesoría
        $advisory = Advisories::create([
            'advisory_detail_id' => $request->advisory_detail_id,
            'teacher_subject_id' => $request->teacher_subject_id,
            'start_date'         => $request->start_date,
            'end_date'           => $request->end_date,
            'day_of_week'        => $request->day_of_week,
            'start_time'         => $request->start_time,
            'end_time'           => $request->end_time,
            'classroom'          => $request->classroom,
            'building'           => $request->building,
            'assignment_file'    => $path,
        ]);

        // Cambiar estado
        $detail->update(['status' => 'Aprobado']);

        // Notificar
        $user = $advisory->teacherSubject->teacher->userRelation;
        $user->notify(new AdvisoryCreated($advisory));

        foreach ($detail->students as $student) {
            if ($student->userRelation) {
                $student->userRelation->notify(new AdvisoryStudentNotification($advisory));
            }
        }

        return redirect()->route('basic_sciences.advisories.index')
            ->with('success', 'Asesoría creada correctamente.');
    }


    public function edit($id)
    {
        $advisory = Advisories::with([
            'teacherSubject.teacher',
            'teacherSubject.subject',
            'teacherSubject.career',
            'advisoryDetail.students',
            'advisoryDetail.requests.subject'
        ])->findOrFail($id);

        return view('basic_sciences.advisories.edit', compact('advisory'));
    }


    public function update(Request $request, $id)
    {
        $advisory = Advisories::findOrFail($id);

        $request->validate([
            'end_date' => 'required|date',
            'day_of_week' => 'required|string',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'classroom' => 'nullable|string|max:10',
            'building' => 'nullable|string|max:10',
        ]);

        if ($request->hasFile('assignment_file')) {
            if ($advisory->assignment_file && Storage::disk('public')->exists($advisory->assignment_file)) {
                Storage::disk('public')->delete($advisory->assignment_file);
            }

            $file = $request->file('assignment_file');
            $path = $file->storeAs('assignments', $file->getClientOriginalName(), 'public');
            $advisory->assignment_file = $path;
        }

        $advisory->update($request->except('assignment_file'));

        return redirect()->route('basic_sciences.advisories.index')
            ->with('success', 'Asesoría actualizada correctamente.');
    }


    public function destroy($id)
    {
        $advisory = Advisories::findOrFail($id);
        $detail   = $advisory->advisoryDetail;

        if ($advisory->assignment_file && Storage::disk('public')->exists($advisory->assignment_file)) {
            Storage::disk('public')->delete($advisory->assignment_file);
        }

        if ($detail) {
            $detail->students()->detach();
            $detail->requests()->detach();
        }

        $advisory->delete();
        $detail->delete();

        return redirect()->route('basic_sciences.advisories.index')
            ->with('success', 'Asesoría eliminada correctamente.');
    }

    //Reporte individual
    public function details($id)
    {
        $advisory = Advisories::with([
            'teacherSubject.teacher',
            'teacherSubject.subject.career',
            'advisoryDetail.students',
            'advisoryDetail.requests.subject.career',
            'reports'
        ])->findOrFail($id);

        // Materia solicitada real
        $solicitud = $advisory->advisoryDetail->requests->first();
        $materiaSolicitada = $solicitud?->subject?->name ?? 'N/A';

        // Carrera de la materia solicitada
        $carreraSolicitada = $solicitud?->subject?->career?->name ?? 'Materia común';

        // Evaluaciones
        $evaluations = Evaluation::where('advisory_id', $advisory->advisory_id)->get();

        $promedioFinal = null;
        if ($evaluations->count() > 0) {
            $promedios = $evaluations->map(function ($ev) {
                return collect(range(1, 11))->reduce(fn($a, $i) => $a + $ev["q$i"], 0) / 11;
            });

            $promedioFinal = round($promedios->avg(), 2);
        }

        return view('basic_sciences.advisories.individual_details', [
            'advisory' => $advisory,
            'students' => $advisory->advisoryDetail->students,
            'materiaSolicitada' => $materiaSolicitada,
            'carreraSolicitada' => $carreraSolicitada, // ← ENVIADO A LA VISTA
            'total'    => $advisory->advisoryDetail->students->count(),
            'hombres'  => $advisory->advisoryDetail->students->where('gender', 'Masculino')->count(),
            'mujeres'  => $advisory->advisoryDetail->students->where('gender', 'Femenino')->count(),
            'reports'  => $advisory->reports,
            'promedioFinal' => $promedioFinal
        ]);
    }


    public function indexCareerHead()
    {
        $admin = Auth::user()->administrative;

        if (!$admin) {
            return back()->withErrors(['error' => 'Tu cuenta no está registrada como Jefe de Carrera.']);
        }

        $careerId = $admin->career_id;

        $query = Advisories::with([
            'teacherSubject.teacher',
            'teacherSubject.subject',
            'advisoryDetail.students',
            'advisoryDetail.requests.subject',
            'advisoryDetail.requests.subject.career',
        ])
            ->whereHas('teacherSubject.teacher', function ($q) use ($careerId) {
                $q->where('career_id', $careerId);   // Solo maestros de mi carrera
            });

        // Filtro por maestro
        if (request('maestro')) {
            $search = request('maestro');
            $query->whereHas('teacherSubject.teacher', function ($q) use ($search) {
                $q->where('name', 'like', "%$search%")
                    ->orWhere('last_name_f', 'like', "%$search%");
            });
        }

        // Filtro por estado
        if (request('estado')) {
            $query->whereHas('advisoryDetail', function ($q) {
                $q->where('status', request('estado'));
            });
        }

        $advisories = $query->orderBy('start_date')->get();

        return view('career_head.advisories.index', compact('advisories'));
    }

    public function detailsCareerHead($id)
    {
        $advisory = Advisories::with([
            'teacherSubject.teacher',
            'teacherSubject.subject',
            'advisoryDetail.students',
            'advisoryDetail.requests.subject.career',
            'reports'
        ])->findOrFail($id);

        // Obtener materia real solicitada
        $solicitud = $advisory->advisoryDetail->requests->first();
        $materiaSolicitada = $solicitud?->subject?->name ?? 'N/A';
        $carreraSolicitada = $solicitud?->subject?->career?->name ?? 'Materia común';

        return view('career_head.advisories.individual_details', [
            'advisory'           => $advisory,
            'students'           => $advisory->advisoryDetail->students,
            'materiaSolicitada'  => $materiaSolicitada,
            'carreraSolicitada'  => $carreraSolicitada,
            'total'              => $advisory->advisoryDetail->students->count(),
            'hombres'            => $advisory->advisoryDetail->students->where('gender', 'Masculino')->count(),
            'mujeres'            => $advisory->advisoryDetail->students->where('gender', 'Femenino')->count(),
            'reports'            => $advisory->reports
        ]);
    }
}
