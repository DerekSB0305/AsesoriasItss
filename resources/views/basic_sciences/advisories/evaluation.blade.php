<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados de Evaluación</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

<x-basic-sciences-navbar/>

<div class="flex-grow p-4 sm:p-6">

<div class="max-w-5xl mx-auto bg-white p-6 sm:p-8 shadow-xl rounded-2xl">

    {{-- REGRESAR --}}
    <a href="{{ url()->previous() }}"
       class="text-indigo-600 hover:text-indigo-800 text-sm block mb-4">
        ← Regresar
    </a>

    {{-- TÍTULO --}}
    <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-800 mb-6 text-center">
        📊 Resultados de Evaluación del Asesor
    </h1>

    {{-- INFO ASESORÍA --}}
    <div class="bg-gray-50 p-4 rounded-lg border mb-8 text-sm sm:text-base leading-relaxed">
        <p><strong>Asesor:</strong>
            {{ $advisory->teacherSubject->teacher->name }}
            {{ $advisory->teacherSubject->teacher->last_name_f }}
            {{ $advisory->teacherSubject->teacher->last_name_m }}
        </p>
        <p class="mt-1"><strong>Materia:</strong>
            {{ $advisory->teacherSubject->subject->name }}
        </p>
        <p class="mt-1"><strong>Carrera:</strong>
            {{ $advisory->teacherSubject->teacher->career->name }}
        </p>
        <p class="mt-1"><strong>Total de evaluaciones recibidas:</strong> {{ $total }}</p>
    </div>

    @if(!$evaluated)
        <p class="text-center text-gray-600 text-lg">
            Aún no hay evaluaciones registradas.
        </p>
    @else
    
    <div class="relative overflow-hidden rounded-2xl shadow-2xl mb-10">

            <div class="absolute inset-0 bg-gradient-to-r from-[#0B3D7E] via-blue-700 to-indigo-800 opacity-90 blur-lg"></div>
            <div class="relative p-6 sm:p-8 text-center text-white">
                <h2 class="text-xl sm:text-2xl font-extrabold drop-shadow-md">
                    Calificación general del asesor
                </h2>
                
                <div class="mt-4 mx-auto w-32 sm:w-40 h-32 sm:h-40 
                    flex items-center justify-center 
                    rounded-full shadow-xl backdrop-blur-xl bg-white/10 border border-white/20">
                        <p class="text-5xl sm:text-6xl font-extrabold text-white drop-shadow-lg">
                            {{ $general }}
                        </p>
                </div>
                
                <p class="mt-3 text-sm text-gray-200">
                    Promedio basado en la evaluación de los alumnos
                </p>
            </div>
        </div>

        {{-- LISTA DE ALUMNOS QUE EVALUARON Y NO EVALUARON --}}
        <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-3">
            🧑‍🎓 Estado de evaluaciones de los alumnos
        </h2>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-10">

            {{-- ALUMNOS QUE EVALUARON --}}
            <div class="border rounded-lg p-4 bg-green-50">
                <h3 class="text-green-700 font-bold mb-3"> Evaluaron ({{ $evaluatedStudents->count() }})</h3>

                @if($evaluatedStudents->count() == 0)
                    <p class="text-gray-600 text-sm">Ningún alumno ha evaluado todavía.</p>
                @else
                    <ul class="space-y-2 text-gray-700 text-sm">
                        @foreach($evaluatedStudents as $stu)
                            <li class="flex items-center gap-2">
                                <span class="text-green-600 text-lg">*</span>
                                {{ $stu->name }} {{ $stu->last_name_f }} {{ $stu->last_name_m }}
                                ({{ $stu->enrollment }})
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

            {{-- ALUMNOS QUE NO EVALUARON --}}
            <div class="border rounded-lg p-4 bg-red-50">
                <h3 class="text-red-700 font-bold mb-3">No evaluaron ({{ $notEvaluatedStudents->count() }})</h3>

                @if($notEvaluatedStudents->count() == 0)
                    <p class="text-gray-600 text-sm">Todos los alumnos evaluaron al asesor.</p>
                @else
                    <ul class="space-y-2 text-gray-700 text-sm">
                        @foreach($notEvaluatedStudents as $stu)
                            <li class="flex items-center gap-2">
                                <span class="text-red-600 text-lg">*</span>
                                {{ $stu->name }} {{ $stu->last_name_f }} {{ $stu->last_name_m }}
                                ({{ $stu->enrollment }})
                            </li>
                        @endforeach
                    </ul>
                @endif
            </div>

        </div>

        {{-- TABLA DE PROMEDIOS --}}
        <h2 class="text-lg sm:text-xl font-bold text-gray-800 mb-3 text-center">
            📝 Promedio por pregunta
        </h2>

        {{-- PC y tablets --}}
        <div class="hidden sm:block overflow-x-auto rounded-lg border shadow-sm mb-10">
            <table class="w-full text-sm">
                <thead class="text-white uppercase font-semibold text-xs bg-[#0B3D7E]">
                    <tr>
                        <th class="px-4 py-3 text-left">Pregunta</th>
                        <th class="px-4 py-3 text-center">Promedio</th>
                    </tr>
                </thead>
                <tbody class="text-gray-700">
                    @foreach($questions as $i => $q)
                    <tr class="border-b hover:bg-gray-50 transition">
                        <td class="px-4 py-3">{{ $i+1 }}. {{ $q }}</td>
                        <td class="px-4 py-3 text-center font-bold text-blue-700">
                            {{ $averages[$i+1] }}
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        {{-- MÓVIL --}}
        <div class="sm:hidden space-y-4">
            @foreach($questions as $i => $q)
                <div class="p-4 border rounded-lg bg-gray-50 shadow-sm">
                    <p class="font-semibold text-gray-800 mb-2">
                        {{ $i+1 }}. {{ $q }}
                    </p>
                    <p class="text-lg font-bold text-blue-700">
                        Promedio: {{ $averages[$i+1] }}
                    </p>
                </div>
            @endforeach
        </div>

    @endif

</div>

</div>

<x-basic-sciences-footer/>

</body>
</html>


