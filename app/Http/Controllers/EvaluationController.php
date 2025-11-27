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
            'advisoryDetail.students'
        ])->findOrFail($advisory_id);

        $evaluations = Evaluation::where('advisory_id', $advisory_id)->get();

        if ($evaluations->count() === 0) {

            return view('basic_sciences.advisories.evaluation', [
                'advisory'             => $advisory,
                'evaluated'            => false,
                'total'                => 0,
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

        $averages = [];
        for ($i = 1; $i <= 11; $i++) {
            $averages[$i] = round($evaluations->avg("q$i"), 2);
        }

        $generalAverage = round(collect($averages)->avg(), 2);

        $students = $advisory->advisoryDetail->students;

        $evaluatedStudents = $students->filter(function ($stu) use ($advisory_id) {
            return Evaluation::where('enrollment', $stu->enrollment)
                ->where('advisory_id', $advisory_id)
                ->exists();
        });

        $notEvaluatedStudents = $students->filter(function ($stu) use ($advisory_id) {
            return !Evaluation::where('enrollment', $stu->enrollment)
                ->where('advisory_id', $advisory_id)
                ->exists();
        });

        return view('basic_sciences.advisories.evaluation', [
            'advisory'             => $advisory,
            'evaluated'            => true,
            'questions'            => $questions,
            'averages'             => $averages,
            'general'              => $generalAverage,
            'total'                => $evaluations->count(),
            'students'             => $students,
            'evaluatedStudents'    => $evaluatedStudents,
            'notEvaluatedStudents' => $notEvaluatedStudents
        ]);
    }
}
