<?php

namespace App\Http\Controllers;

use App\Models\Advisories;
use App\Models\Evaluation;
use Illuminate\Http\Request;

class EvaluationController extends Controller
{
    public function show($advisory_id)
    {
        $advisory = Advisories::with([
            'teacherSubject.teacher',
            'teacherSubject.subject',
            'teacherSubject.subject.career',
            'advisoryDetail.students',
            'advisoryDetail.requests.subject.career'
        ])->findOrFail($advisory_id);

        $solicitud = $advisory->advisoryDetail->requests->first();

        $materiaSolicitada = $solicitud?->subject?->name ?? 'N/A';
        $carreraSolicitada = $solicitud?->subject?->career?->name ?? 'Materia común';

        $evaluations = Evaluation::where('advisory_id', $advisory_id)->get();

        if ($evaluations->count() === 0) {

            return view('basic_sciences.advisories.evaluation', [
                'advisory'             => $advisory,
                'evaluated'            => false,
                'total'                => 0,
                'materiaSolicitada'    => $materiaSolicitada,
                'carreraSolicitada'    => $carreraSolicitada,
                'students'             => $advisory->advisoryDetail->students,
                'evaluatedStudents'    => collect(),
                'notEvaluatedStudents' => $advisory->advisoryDetail->students,
            ]);
        }

        $questions = [
            "EXPLICA LOS CONTENIDOS DE LA ASIGNATURA",
            "RESUELVE DUDAS",
            "PRESENTA CLASE ORGANIZADA",
            "COMPROMISO Y ENTUSIASMO",
            "TOMA EN CUENTA NECESIDADES",
            "HACE INTERESANTE LA ASIGNATURA",
            "CLIMA DE APERTURA",
            "ESCUCHA OPINIONES",
            "ACCESIBLE Y BRINDA AYUDA",
            "ES UN BUEN ASESOR",
            "LO RECOMENDARÍA A OTROS"
        ];

        // Promedios por pregunta
        $averages = [];
        for ($i = 1; $i <= 11; $i++) {
            $averages[$i] = round($evaluations->avg("q$i"), 2);
        }

        // Promedio general
        $generalAverage = round(collect($averages)->avg(), 2);

        $students = $advisory->advisoryDetail->students;

        $evaluatedStudents = $students->filter(
            fn($stu) =>
            Evaluation::where('enrollment', $stu->enrollment)
                ->where('advisory_id', $advisory_id)
                ->exists()
        );

        $notEvaluatedStudents = $students->filter(
            fn($stu) =>
            !Evaluation::where('enrollment', $stu->enrollment)
                ->where('advisory_id', $advisory_id)
                ->exists()
        );

        return view('basic_sciences.advisories.evaluation', [
            'advisory'             => $advisory,
            'evaluated'            => true,
            'questions'            => $questions,
            'averages'             => $averages,
            'general'              => $generalAverage,
            'materiaSolicitada'    => $materiaSolicitada,
            'carreraSolicitada'    => $carreraSolicitada,
            'total'                => $evaluations->count(),
            'students'             => $students,
            'evaluatedStudents'    => $evaluatedStudents,
            'notEvaluatedStudents' => $notEvaluatedStudents
        ]);
    }
}
