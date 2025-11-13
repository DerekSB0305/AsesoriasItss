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
    public function index()
    {
        $advisories = Advisories::with(['teacher', 'subject', 'detail.student'])->get();

        return view('basic_sciences.advisories.index', compact('advisories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $detail_id = $request->detail_id;

        // Cargar detalle
        $detail = Advisory_details::with('request.student', 'request.subject')->findOrFail($detail_id);

        // Cargar maestros que pueden dar esta materia
        $teacherSubjects = TeacherSubject::with('teacher')
            ->where('subject_id', $detail->request->subject_id)
            ->get();

        return view('basic_sciences.advisories.create', compact('detail', 'teacherSubjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'teacher_subject_id' => 'required|exists:teacher_subjects,teacher_subject_id',
            'advisory_detail_id' => 'required|exists:advisory_details,advisory_detail_id',
            'schedule' => 'required|date',
            'classroom' => 'nullable|string|max:10',
            'building' => 'nullable|string|max:10',
            'assignment_file' => 'nullable|file|mimes:pdf,jpg,png,docx|max:2048',
        ]);

        $filePath = null;
        if ($request->hasFile('assignment_file')) {
            $filePath = $request->file('assignment_file')->store('assignments', 'public');
        }

        Advisories::create([
            'teacher_subject_id' => $request->teacher_subject_id,
            'advisory_detail_id' => $request->advisory_detail_id,
            'schedule' => $request->schedule,
            'classroom' => $request->classroom,
            'building' => $request->building,
            'assignment_file' => $filePath
        ]);


        return redirect()->route('basic_sciences.index')->with('success', 'Asesoría registrada correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Advisories $advisories)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Advisories $advisories)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Advisories $advisories)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advisories $advisories)
    {
        $advisory = Advisories::findOrFail($advisories->id);

        if ($advisory->detail) {
            $advisory->detail->delete();
        }

        $advisory->delete();

        return redirect()->route('basic_sciences.advisories.index')
            ->with('success', 'Asesoría eliminada correctamente.');
    }
}
