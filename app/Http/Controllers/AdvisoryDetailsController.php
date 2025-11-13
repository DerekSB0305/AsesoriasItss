<?php

namespace App\Http\Controllers;

use App\Models\Advisories;
use Illuminate\Http\Request; 
use App\Models\Requests;
use App\Models\Advisory_details; 

class AdvisoryDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
       $materia = $request->materia;
    $estado = $request->estado;

    $details = Advisory_details::with(['students', 'advisories.teacherSubject.subject'])
        ->when($materia, function ($q) use ($materia) {
            $q->whereHas('advisories.teacherSubject.subject', function ($sub) use ($materia) {
                $sub->where('name', 'LIKE', "%$materia%");
            });
        })
        ->when($estado, function ($q) use ($estado) {
            $q->where('status', $estado);
        })
        ->orderBy('advisory_detail_id', 'DESC')
        ->get();

    return view('basic_sciences.advisory_details.index', compact('details', 'materia', 'estado'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
           // Traer materias que han sido solicitadas (desde requests)
        $subjects = Requests::with('subject')
            ->select('subject_id')
            ->distinct()
            ->get()
            ->map(fn($r) => $r->subject)
            ->filter();

        return view('basic_sciences.advisory_details.create', compact('subjects'));
    }

 public function getStudentsBySubject(int $subject_id)
    {
        $students = Requests::where('subject_id', $subject_id)
            ->with('student')
            ->get()
            ->map(function ($req) {
                return [
                    'request_id' => $req->request_id,
                    'enrollment' => $req->student->enrollment,
                    'name'       => $req->student->name,
                    'last_name_f'=> $req->student->last_name_f,
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
            'subject_id'   => 'required|integer|exists:subjects,subject_id',
            'request_id'   => 'required|array', // array de request_id seleccionados
            'observations' => 'nullable|string|max:255',
        ]);

        // Crear detalle asesoría
        $detail = Advisory_details::create([
            'status'       => 'Pending',
            'observations' => $request->observations,
        ]);

         foreach ($request->request_id as $reqId) {
            $req = Requests::find($reqId);

            if ($req && $req->student) {
                $detail->students()->attach($req->student->enrollment);
            }
        }

         return redirect()->route('basic_sciences.advisories.create', [
            'detail_id' => $detail->advisory_detail_id
        ])->with('success', 'Detalle creado, ahora completa la asesoría.');
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
         $advisory_details->load('students');
        return view('basic_sciences.advisory_details.show', compact('advisory_details'));
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Advisory_details $advisory_details)
    {
         $advisory_details->delete();

        return redirect()->route('basic_sciences.advisory_details.index')
            ->with('success', 'Detalle eliminado correctamente.');
    }
}
