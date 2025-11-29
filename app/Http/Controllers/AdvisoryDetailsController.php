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
        $estado  = $request->estado;

        $details = Advisory_details::with([
            'students',
            'advisories',
            'requests.subject',
            'requests.subject.career',
        ])
            ->when($materia, function ($q) use ($materia) {

                $q->whereHas('requests.subject', function ($sub) use ($materia) {
                    $sub->where('name', 'LIKE', "%$materia%");
                });
            })
            ->when($estado, function ($q) use ($estado) {
                $q->where('status', $estado);
            })
            ->orderBy('advisory_detail_id', 'DESC')
            ->get();

        return view(
            'basic_sciences.advisory_details.index',
            compact('details', 'materia', 'estado')
        );
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {

        // Traer materias que han sido solicitadas (desde requests)
        $subjects = Requests::with('subject')
            ->select('subject_id')
            ->distinct()
            ->get()
            ->map(fn($r) => $r->subject)
            ->filter();

        // Si viene desde solicitudes
        $subjectId = $request->subject_id ?? null;

        return view('basic_sciences.advisory_details.create', [
            'subjects' => $subjects,
            'subjectId' => $subjectId
        ]);
    }

    public function getStudents($subject_id)
    {
        //  Solicitudes hechas para esta materia
        $requests = Requests::where('subject_id', $subject_id)
            ->with('student')
            ->get();

        //  Alumnos con asesoría activa (Aprobado)
        $alumnosActivos = Advisories::whereHas('advisoryDetail', function ($q) {
            $q->where('status', 'Aprobado');
        })
            ->with('advisoryDetail.students')
            ->get()
            ->flatMap(fn($adv) => $adv->advisoryDetail->students->pluck('enrollment'))
            ->unique()
            ->toArray();

        //  Alumnos con asesoría pendiente
        $alumnosPendientes = Advisories::whereHas('advisoryDetail', function ($q) {
            $q->where('status', 'Pendiente');
        })
            ->with('advisoryDetail.students')
            ->get()
            ->flatMap(fn($adv) => $adv->advisoryDetail->students->pluck('enrollment'))
            ->unique()
            ->toArray();

        //  Alumnos que ya llevaron esta materia (Finalizados)
        $alumnosRepetidores = Advisories::whereHas('advisoryDetail', function ($q) {
            $q->where('status', 'Finalizado');
        })
            ->whereHas('advisoryDetail.requests', function ($q) use ($subject_id) {
                $q->where('subject_id', $subject_id);
            })
            ->with('advisoryDetail.students')
            ->get()
            ->flatMap(fn($adv) => $adv->advisoryDetail->students)
            ->keyBy('enrollment');


        //  Unir alumnos bloqueados (activos + pendientes)
        $bloqueados = array_unique(array_merge($alumnosActivos, $alumnosPendientes));

        //  Filtrar alumnos disponibles
        $alumnosDisponibles = $requests->filter(function ($req) use ($bloqueados) {
            return !in_array($req->student->enrollment, $bloqueados);
        });

        return response()->json([
            'disponibles' => $alumnosDisponibles->map(function ($req) {
                return [
                    'request_id' => $req->request_id,
                    'enrollment' => $req->student->enrollment,
                    'name'       => $req->student->name,
                    'last_name_f' => $req->student->last_name_f,
                    'last_name_m' => $req->student->last_name_m,
                ];
            })->values(),

            'repetidores' => $alumnosRepetidores->map(function ($stu) {
                return [
                    'enrollment' => $stu->enrollment,
                    'name'       => $stu->name,
                    'last_name_f' => $stu->last_name_f,
                    'last_name_m' => $stu->last_name_m,
                ];
            })->values(),
        ]);
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
            'status'       => 'Pendiente',
            'observations' => $request->observations,
        ]);

        foreach ($request->request_id as $reqId) {

            // Guarda la solicitud asociada
            $detail->requests()->attach($reqId);

            // Agrega el alumno relacionado
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
