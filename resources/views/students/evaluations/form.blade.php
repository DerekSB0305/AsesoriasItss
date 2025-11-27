<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Evaluación del Asesor</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

<x-students-navbar/>

<div class="flex-grow p-4 sm:p-6">

<div class="max-w-4xl mx-auto bg-white p-4 sm:p-8 shadow-xl rounded-2xl">

    <!-- REGRESAR -->
    <a href="{{ route('students.panel.advisories') }}"
       class="text-indigo-600 hover:text-indigo-800 text-sm block mb-4">
        ← Regresar a mis asesorías
    </a>

    <!-- TÍTULO -->
    <h1 class="text-xl sm:text-3xl font-extrabold text-gray-800 mb-6 text-center">
        🧑‍🏫 Evaluación del Desempeño del Asesor
    </h1>

    <!-- INFO DEL ASESOR -->
    <div class="bg-gray-50 p-4 rounded-lg border mb-6 text-base">
        <p class="text-gray-700">
            <strong>Asesor:</strong>
            {{ $advisory->teacherSubject->teacher->name }}
            {{ $advisory->teacherSubject->teacher->last_name_f }}
            {{ $advisory->teacherSubject->teacher->last_name_m }}
        </p>

        <p class="text-gray-700 mt-2">
            <strong>Materia:</strong>
            {{ $advisory->teacherSubject->subject->name }}
        </p>
    </div>

    <!-- FORMULARIO -->
    <form method="POST" action="{{ route('students.panel.evaluate.store', $advisory->advisory_id) }}">
        @csrf

        @php
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
        @endphp

        @foreach($questions as $index => $q)

            <div class="mb-6 bg-gray-50 p-4 rounded-xl border">

                <!-- PREGUNTA -->
                <p class="font-semibold text-gray-800 mb-4 text-base sm:text-lg leading-snug">
                    {{ $index + 1 }}. {{ $q }}
                </p>

                <!-- ESCALA RESPONSIVE -->
                <div class="grid grid-cols-3 sm:grid-cols-5 gap-4 text-center">

                    @for($i = 1; $i <= 5; $i++)
                        <label class="cursor-pointer flex flex-col items-center p-2">

                            <input type="radio"
                                   name="q{{ $index+1 }}"
                                   value="{{ $i }}"
                                   required
                                   class="w-5 h-5 sm:w-6 sm:h-6 text-blue-700 focus:ring-[#0B3D7E]">

                            <span class="text-base sm:text-lg mt-2 font-medium">{{ $i }}</span>
                        </label>
                    @endfor

                </div>

            </div>

        @endforeach

        <!-- BOTÓN -->
        <button class="w-full bg-[#0B3D7E] text-white py-4 rounded-xl shadow-md 
                       hover:bg-blue-900 transition font-semibold text-lg sm:text-xl">
            Enviar evaluación
        </button>

    </form>

</div>
</div>

<x-basic-sciences-footer />

</body>
</html>
