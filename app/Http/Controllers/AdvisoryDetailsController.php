<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; 
use App\Models\Requests;
use App\Models\Advisory_details; 

class AdvisoryDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
           $subjects = Requests::with('subject')
            ->select('subject_id')
            ->distinct()
            ->get()
            ->map(function ($req) {
                return $req->subject;
            })
            ->filter();

        return view('basic_sciences.advisory_details.create', compact('subjects'));
    }

 public function getStudentsBySubject(int $subject_id)
    {
        // Trae las solicitudes de esa materia junto con el alumno
        $requests = Requests::with('student')
            ->where('subject_id', $subject_id)
            ->get();

        if ($requests->isEmpty()) {
            return response()->json([
                'error' => 'No hay solicitudes registradas para esta materia.'
            ], 404);
        }

        $students = $requests->map(function ($req) {
            $student = $req->student;
            return [
                'request_id' => $req->request_id,
                'enrollment' => $student->enrollment ?? '',
                'name' => "{$student->name} {$student->last_name_f} {$student->last_name_m}",
            ];
        });

        return response()->json($students);
    }
    /**
     * Crea uno o varios advisory_details a partir de los request_id seleccionados.
     * Tras crear, redirige a crear la Asesoría usando el primer detalle.
     */
    public function store(Request $request)
    {
       
       $request->validate([
        'subject_id' => 'required|integer|exists:subjects,subject_id',
        'request_id' => 'required|array',
        'request_id.*' => 'integer|exists:requests,request_id',
        'observations' => 'nullable|string|max:255',
    ]);

    foreach ($request->request_id as $reqId) {
        Advisory_details::create([
            'request_id' => $reqId,
            'status' => 'Pending',
            'observations' => $request->observations,
        ]);
    }

    return redirect()
        ->route('basic_sciences.advisories.create')
        ->with('success', 'Detalles registrados, continúe con la asesoría.');
    }

    /**
     * Store a newly created resource in storage.
     */

    // Traer a los alumnos por materia
  
    /**
     * Display the specified resource.
     */
    public function show(Advisory_details $advisory_details)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Advisory_details $advisory_details)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Advisory_details $advisory_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advisory_details $advisory_details)
    {
        //
    }
}
