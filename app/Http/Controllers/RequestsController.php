<?php

namespace App\Http\Controllers;

use App\Models\Requests;
use App\Models\Student;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RequestsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $requests = Requests::all();
        return view('basic_sciences.requests.index', compact('requests'));
    }

    public function indexTeacher()
    {
        $teacher_user = Auth::user()->teacher->teacher_user;

        $requests = Requests::where('teacher_user', $teacher_user)
                    ->with(['student','subject'])
                    ->get();

        return view('teachers.requests.index', compact('requests'));
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
            $teacher_user = Auth::user()->teacher->teacher_user;

    $students = Student::where('teacher_user', $teacher_user)->get();
    $subjects = Subject::all();

    return view('teachers.requests.create', compact('students','subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
            $request->validate([
        'enrollments'   => ['required', 'array'],
        'enrollments.*' => ['string', 'exists:students,enrollment'],

        'subject_id'    => ['required', 'integer', 'exists:subjects,subject_id'],

        'reason'        => ['nullable', 'string', 'max:500'],
        'canalization_file' => ['nullable','file','mimes:pdf,jpg,jpeg,png','max:2048'],
    ]);

    $teacher = Auth::user()->teacher;
    if (!$teacher) {
        abort(403, "Solo los docentes pueden crear solicitudes.");
    }

    // Guardar archivo una sola vez (opcional)
    $path = null;
    if ($request->hasFile('canalization_file')) {
        $path = $request->file('canalization_file')->store('canalizations', 'public');
    }

    // Crear una solicitud por alumno
    foreach ($request->enrollments as $enrollment) {
        Requests::create([
            'enrollment' => $enrollment,
            'teacher_user' => $teacher->teacher_user,
            'subject_id' => $request->subject_id,
            'reason' => $request->reason,
            'canalization_file' => $path,
        ]);
    }

    return redirect()
        ->route('teachers.requests.index')
        ->with('success', 'Solicitudes enviadas correctamente.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Requests $requests)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Requests $requests)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Requests $requests)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Requests $requests)
    {
        //
    }
}
