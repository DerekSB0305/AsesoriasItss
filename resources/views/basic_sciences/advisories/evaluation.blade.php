<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Resultados de Evaluación</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

<x-basic-sciences-navbar/>

<div class="flex-grow p-4 sm:p-6">

<div class="max-w-6xl mx-auto bg-white p-6 sm:p-8 shadow-xl rounded-2xl">
    
    <a href="{{ route('basic_sciences.advisories.index') }}"
    class="inline-flex items-center bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300 transition mb-4 text-sm sm:text-base">
         ← Volver
    </a>

    <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0B3D7E] mb-6 text-center">
        📊 Resultados de Evaluación del Asesor
    </h1>

    <div class="bg-gray-50 p-5 rounded-xl border mb-8 text-sm sm:text-base leading-relaxed shadow">
        <p><strong>Asesor:</strong>
            {{ $advisory->teacherSubject->teacher->name }}
            {{ $advisory->teacherSubject->teacher->last_name_f }}
            {{ $advisory->teacherSubject->teacher->last_name_m }}
        </p>

        <p class="mt-1"><strong>Materia solicitada:</strong>
            {{ $materiaSolicitada }}
        </p>

        <p class="mt-1"><strong>Carrera de la materia:</strong>
            {{ $carreraSolicitada }}
        </p>

        <p class="mt-1"><strong>Total de evaluaciones recibidas:</strong> {{ $total }}</p>
    </div>

    @if($total == 0)
        <p class="text-center text-gray-600 text-lg mb-10">
            Aún no hay evaluaciones registradas.
        </p>
    @endif

    @if($total > 0)
        <div class="relative overflow-hidden rounded-2xl shadow-2xl mb-12">
            <div class="absolute inset-0 bg-gradient-to-r from-[#0B3D7E] via-blue-700 to-indigo-800 opacity-80 blur-xl"></div>

            <div class="relative p-8 text-center text-white">
                <h2 class="text-xl sm:text-2xl font-extrabold drop-shadow-md">
                    Calificación general del asesor
                </h2>

                <div class="mt-6 mx-auto w-36 h-36 sm:w-48 sm:h-48
                    flex items-center justify-center rounded-full
                    shadow-2xl backdrop-blur-xl bg-white/10 border border-white/20">
                    <p class="text-5xl sm:text-6xl font-extrabold drop-shadow-lg">
                        {{ $general }}
                    </p>
                </div>

                <p class="mt-3 text-sm text-gray-200">
                    Promedio basado en la evaluación de los alumnos
                </p>
            </div>
        </div>
    @endif

    <h2 class="text-xl font-bold text-gray-800 mb-4">Estado de evaluaciones de los alumnos</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-12">

        <div class="border rounded-xl p-5 bg-green-50 shadow">
            <h3 class="text-green-700 font-bold mb-3">
                Evaluaron ({{ $evaluatedStudents->count() }})
            </h3>

            @if($evaluatedStudents->count() == 0)
                <p class="text-gray-600 text-sm">Ningún alumno ha evaluado todavía.</p>
            @else
                <ul class="space-y-2 text-gray-700 text-sm">
                    @foreach($evaluatedStudents as $stu)
                        <li class="flex items-center gap-2">
                            <span class="text-green-600">*</span>
                            {{ $stu->name }} {{ $stu->last_name_f }} {{ $stu->last_name_m }}
                            ({{ $stu->enrollment }})
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

        <div class="border rounded-xl p-5 bg-red-50 shadow">
            <h3 class="text-red-700 font-bold mb-3">
                No evaluaron ({{ $notEvaluatedStudents->count() }})
            </h3>

            @if($notEvaluatedStudents->count() == 0)
                <p class="text-gray-600 text-sm">Todos los alumnos evaluaron al asesor.</p>
            @else
                <ul class="space-y-2 text-gray-700 text-sm">
                    @foreach($notEvaluatedStudents as $stu)
                        <li class="flex items-center gap-2">
                            <span class="text-red-600">*</span>
                            {{ $stu->name }} {{ $stu->last_name_f }} {{ $stu->last_name_m }}
                            ({{ $stu->enrollment }})
                        </li>
                    @endforeach
                </ul>
            @endif
        </div>

    </div>

    @if($total > 0)

        <h2 class="text-xl font-bold text-gray-800 mb-4 text-center">
            📝 Promedio por pregunta
        </h2>

        <div class="hidden sm:block overflow-x-auto rounded-xl border shadow-lg mb-10">
            <table class="w-full text-sm">
                <thead class="bg-[#0B3D7E] text-white uppercase text-xs font-semibold">
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

        <div class="sm:hidden space-y-4">
            @foreach($questions as $i => $q)
                <div class="p-4 border rounded-lg bg-gray-50 shadow">
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



