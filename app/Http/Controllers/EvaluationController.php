<?php

namespace App\Http\Controllers;

use App\Models\Advisories;
use App\Models\Evaluation;
use App\Models\Student;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function show($id)
    {
        $advisory = Advisories::with([
            'teacherSubject.teacher',
            'advisoryDetail.students',
            'advisoryDetail.requests.subject',
        ])->findOrFail($id);

        // materia solicitada
        $solicitud = $advisory->advisoryDetail->requests->first();
        $materiaSolicitada = $solicitud?->subject?->name ?? 'Materia no disponible';
        $carreraSolicitada = $solicitud?->subject?->career?->name ?? 'Materia común';

        // alumnos inscritos
        $students = $advisory->advisoryDetail->students;

        // evaluaciones registradas
        $evaluations = Evaluation::where('advisory_id', $id)->get();
        $total = $evaluations->count();

        // alumnos que evaluaron
        $evaluatedStudents = $students->filter(function ($stu) use ($evaluations) {
            return $evaluations->where('enrollment', $stu->enrollment)->count() > 0;
        });

        // alumnos que no evaluaron
        $notEvaluatedStudents = $students->filter(function ($stu) use ($evaluations) {
            return $evaluations->where('enrollment', $stu->enrollment)->count() == 0;
        });

        // cálculo de promedios (solo si hay evaluaciones)
        $questions = [
            'EXPLICA DE MANERA CLARA LOS CONTENIDOS DE LA ASIGNATURA.',
            'RESUELVE LAS DUDAS RELACIONADAS CON LOS CONTENIDOS DE LA ASIGNATURA.',
            'PRESENTA Y EXPONE LAS CLASES DE MANERA ORGANIZADA Y ESTRUCTURADA.',
            'MUESTRA COMPROMISO Y ENTUSIASMO EN SUS ACTIVIDADES DOCENTES.',
            'TOMA EN CUENTA LAS NECESIDADES, INTERESES Y EXPECTATIVAS DEL GRUPO.',
            'HACE INTERESANTE LA ASIGNATURA.',
            'DESARROLLA LA CLASE EN UN CLIMA DE APERTURA Y ENTENDIMIENTO.',
            'ESCUCHA Y TOMA EN CUENTA LAS OPINIONES DE LOS ESTUDIANTES.',
            'ES ACCESIBLE Y BRINDA AYUDA ACADÉMICA.',
            'EN GENERAL, PIENSO QUE ES UN BUEN ASESOR.',
            'YO RECOMENDARÍA A ESTE ASESOR A OTROS COMPAÑEROS.'
        ];

        $averages = [];

        if ($total > 0) {
            for ($i = 1; $i <= 11; $i++) {
                $averages[$i] = round($evaluations->avg("q$i"), 2);
            }

            $general = round(array_sum($averages) / count($averages), 2);
        } else {
            $general = null;
        }

        return view('basic_sciences.advisories.evaluation', compact(
            'advisory',
            'materiaSolicitada',
            'carreraSolicitada',
            'total',
            'evaluatedStudents',
            'notEvaluatedStudents',
            'questions',
            'averages',
            'general'
        ));
    }
}
