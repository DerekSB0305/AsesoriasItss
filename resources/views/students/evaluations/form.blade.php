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

<div class="max-w-4xl mx-auto bg-white p-6 sm:p-10 shadow-2xl rounded-3xl">

    <!-- VOLVER -->
    <a href="{{ route('students.panel.advisories') }}"
       class="text-[#0B3D7E] hover:text-blue-900 text-sm font-semibold block mb-6 transition">
        ← Regresar a mis asesorías
    </a>

    <!-- TÍTULO -->
    <h1 class="text-3xl font-extrabold text-gray-900 mb-6 text-center tracking-tight">
        📝 Evaluación del Asesor
    </h1>

    <!-- INFO -->
    <div class="bg-[#F5F7FA] border border-gray-200 p-5 rounded-2xl mb-8">
        <p class="text-gray-700 text-base">
            <strong class="text-gray-900">Asesor:</strong>
            {{ $advisory->teacherSubject->teacher->name }}
            {{ $advisory->teacherSubject->teacher->last_name_f }}
            {{ $advisory->teacherSubject->teacher->last_name_m }}
        </p>
        <p class="text-gray-700 mt-2 text-base">
            <strong class="text-gray-900">Materia:</strong>
            {{ $materiaSolicitada }}
        </p>
    </div>

    <!-- ESCALA VISUAL -->
    <div class="bg-[#0B3D7E] text-white p-4 rounded-xl mb-10 shadow-lg text-center">
        <div class="flex flex-wrap justify-center gap-4 text-xs sm:text-sm font-semibold">
            <span class="px-2 py-1 bg-white/10 rounded-md">1 - Insuficiente</span>
            <span class="px-2 py-1 bg-white/10 rounded-md">2 - Regular</span>
            <span class="px-2 py-1 bg-white/10 rounded-md">3 - Bueno</span>
            <span class="px-2 py-1 bg-white/10 rounded-md">4 - Muy bueno</span>
            <span class="px-2 py-1 bg-white/10 rounded-md">5 - Excelente</span>
        </div>
    </div>

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

            <div class="mb-10 bg-white border border-gray-200 shadow-md p-6 rounded-2xl">

                <p class="font-semibold text-gray-900 text-lg mb-6 leading-relaxed">
                    {{ $index + 1 }}. {{ $q }}
                </p>

                <div class="grid grid-cols-5 gap-4">

                    @for($i = 1; $i <= 5; $i++)
                        <label class="block">
                            <input type="radio"
                                   name="q{{ $index+1 }}"
                                   value="{{ $i }}"
                                   class="hidden peer"
                                   required>

                            <div class="flex flex-col items-center p-3 rounded-xl border border-gray-300
                                        peer-checked:border-[#0B3D7E] peer-checked:bg-[#0B3D7E]/10
                                        transition cursor-pointer hover:bg-gray-100 shadow-sm">

                                <span class="text-lg font-bold text-gray-800 peer-checked:text-[#0B3D7E]">
                                    {{ $i }}
                                </span>
                            </div>
                        </label>
                    @endfor

                </div>

            </div>

        @endforeach

        <!-- BOTÓN -->
        <button class="w-full bg-[#28A745] text-white py-4 rounded-xl shadow-xl
                    hover:bg-[#1F7A36] transition font-bold text-lg tracking-wide">
            Enviar evaluación
        </button>


    </form>

</div>
</div>

<x-basic-sciences-footer/>

</body>
</html>
