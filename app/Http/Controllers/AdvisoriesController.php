<?php

namespace App\Http\Controllers;

use App\Models\Advisories;
use App\Models\Advisory_details;
use App\Models\TeacherSubject;
use Illuminate\Http\Request;

class AdvisoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       $query = Advisories::with(['teacherSubject.teacher', 'teacherSubject.subject']);

    if ($request->q) {
        $query->whereHas('teacherSubject.teacher', function($q) use ($request){
            $q->where('name', 'LIKE', '%'.$request->q.'%');
        })->orWhereHas('teacherSubject.subject', function($q) use ($request){
            $q->where('name', 'LIKE', '%'.$request->q.'%');
        });
    }

    $advisories = $query->get();

    return view('basic_sciences.advisories.index', compact('advisories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $detailId = $request->detail_id;

        if (!$detailId) {
            return redirect()->route('basic_sciences.advisory_details.create')
                ->with('error', 'Primero crea un detalle de asesoría.');
        }

        $detail = Advisory_details::with('students')->findOrFail($detailId);

        // Todas las combinaciones maestro-materia-carrera
        $teacherSubjects = TeacherSubject::with(['teacher', 'subject', 'career'])->get();

        return view('basic_sciences.advisories.create', compact('detail', 'teacherSubjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'advisory_detail_id' => 'required|exists:advisory_details,advisory_detail_id',
            'teacher_subject_id' => 'required|exists:teacher_subjects,teacher_subject_id',
            'schedule'           => 'required|date',
            'classroom'          => 'nullable|string|max:10',
            'building'           => 'nullable|string|max:10',
            'assignment_file'    => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:4096',
        ]);

        $path = null;
        if ($request->hasFile('assignment_file')) {
            $path = $request->file('assignment_file')->store('assignments', 'public');
        }

        $advisory = Advisories::create([
            'advisory_detail_id' => $request->advisory_detail_id,
            'teacher_subject_id' => $request->teacher_subject_id,
            'schedule'           => $request->schedule,
            'classroom'          => $request->classroom,
            'building'           => $request->building,
            'assignment_file'    => $path,
        ]);

        // Opcional: actualizar estado del detalle
        $detail = Advisory_details::find($request->advisory_detail_id);
        if ($detail) {
            $detail->status = 'Approved';
            $detail->save();
        }

        return redirect()->route('basic_sciences.advisories.index')
            ->with('success', 'Asesoría creada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Advisories $advisories)
    {
        $advisories->load('detail.students', 'teacherSubject.teacher', 'teacherSubject.subject');
        return view('basic_sciences.advisories.show', compact('advisories'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
       $advisory = Advisories::with([
        'teacherSubject.teacher',
        'teacherSubject.subject',
        'teacherSubject.career',
        'advisoryDetail.students'
    ])->findOrFail($id);

    // alumnos inscritos actualmente
    $currentStudents = $advisory->advisoryDetail->students->pluck('enrollment')->toArray();

    // alumnos disponibles para esa materia (los que solicitaron asesoría)
    $students = \App\Models\Requests::where('subject_id', $advisory->teacherSubject->subject_id)
        ->with('student')
        ->get()
        ->map(function ($req) {
            return [
                'enrollment' => $req->student->enrollment,
                'name'       => $req->student->name . ' ' . $req->student->last_name_f,
            ];
        });

    return view('basic_sciences.advisories.edit', compact('advisory', 'students', 'currentStudents'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
       $advisory = Advisories::findOrFail($id);

    $request->validate([
        'schedule' => 'required|date',
        'classroom' => 'nullable|string|max:10',
        'building' => 'nullable|string|max:10',
        'students' => 'required|array',
    ]);

    // Actualizar información básica de la asesoría
    $advisory->update([
        'schedule' => $request->schedule,
        'classroom' => $request->classroom,
        'building' => $request->building,
    ]);

    // Actualizar alumnos en el detalle
    $advisory->advisoryDetail->students()->sync($request->students);

    return redirect()
        ->route('basic_sciences.advisories.index')
        ->with('success', 'Asesoría actualizada correctamente.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advisories $advisories)
    {
        $advisories->delete();

        return redirect()->route('basic_sciences.advisories.index')
            ->with('success', 'Asesoría eliminada correctamente.');
    }
}
