<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de Asesoría</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

<x-career-head-navbar />

<main class="flex-1 mt-28 mb-10 px-4">

<div class="max-w-4xl mx-auto bg-white shadow-lg rounded-xl p-6 sm:p-8">

    <a href="{{ route('career_head.advisories.index') }}"
       class="inline-flex items-center bg-gray-200 text-gray-800 px-4 py-2 rounded-md 
              hover:bg-gray-300 transition mb-4 text-sm sm:text-base">
        ← Volver
    </a>

    <h1 class="text-xl sm:text-2xl font-bold mb-4 text-gray-800">
        Detalles de Asesoría #{{ $advisory->advisory_id }}
    </h1>

    {{-- ⭐ Calificación general --}}
    @if($totalEvaluaciones > 0)
        <div class="w-full mb-8">

            <div class="relative overflow-hidden rounded-3xl p-8 text-center shadow-2xl
                        bg-gradient-to-r from-[#0a3a8a] via-[#3458d1] to-[#4d3ac9]
                        text-white ring-1 ring-blue-900/40">

                <div class="absolute inset-0 rounded-3xl 
                            bg-gradient-to-r from-blue-600/20 via-purple-500/20 to-blue-900/20 
                            blur-2xl opacity-70"></div>

                <div class="relative z-10">
                    <h2 class="text-xl sm:text-3xl font-extrabold mb-4 drop-shadow-md">
                        Calificación general del asesor
                    </h2>

                    <div class="mx-auto w-40 h-40 sm:w-48 sm:h-48 rounded-full flex items-center justify-center
                                bg-white/10 backdrop-blur-md shadow-xl ring-2 ring-white/20">
                        <p class="text-5xl sm:text-6xl font-extrabold tracking-wide drop-shadow-lg">
                            {{ $general }}
                        </p>
                    </div>

                    <p class="text-sm sm:text-base mt-4 opacity-90">
                        Basado en {{ $totalEvaluaciones }} evaluaciones de alumnos
                    </p>
                </div>
            </div>

        </div>
    @endif

    {{-- Info general --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 text-gray-700 mb-6 text-sm sm:text-base">

        <div>
            <p><strong>Maestro:</strong><br>
                {{ $advisory->teacherSubject->teacher->name }}
                {{ $advisory->teacherSubject->teacher->last_name_f }}
                {{ $advisory->teacherSubject->teacher->last_name_m }}
            </p>
        </div>

        <div>
            <p><strong>Materia solicitada:</strong><br>
                {{ $materiaSolicitada }}
            </p>
        </div>

        <div>
            <p><strong>Carrera solicitada:</strong><br>
                {{ $carreraSolicitada }}
            </p>
        </div>

        <div>
            <p><strong>Periodo:</strong><br>
                {{ \Carbon\Carbon::parse($advisory->start_date)->format('d/m/Y') }}
                -
                {{ \Carbon\Carbon::parse($advisory->end_date)->format('d/m/Y') }}
            </p>
        </div>

        <div>
            <p><strong>Día y Hora:</strong><br>
                {{ ucfirst($advisory->day_of_week) }}
                {{ \Carbon\Carbon::parse($advisory->start_time)->format('H:i') }}
                -
                {{ \Carbon\Carbon::parse($advisory->end_time)->format('H:i') }}
            </p>
        </div>

        <div>
            <p><strong>Aula:</strong><br>
                {{ $advisory->classroom ?? 'N/A' }}
            </p>
        </div>

        <div>
            <p><strong>Edificio:</strong><br>
                {{ $advisory->building ?? 'N/A' }}
            </p>
        </div>

        <div>
            <p><strong>Estado:</strong><br>
                {{ $advisory->advisoryDetail->status }}
            </p>
        </div>

    </div>

    {{-- Resumen de alumnos --}}
    <h2 class="text-lg sm:text-xl font-semibold mb-3 text-gray-800">Resumen de alumnos</h2>

    <div class="flex flex-wrap gap-6 mb-6 text-sm sm:text-base">
        <p><strong>Total:</strong> {{ $total }}</p>
        <p class="text-blue-600"><strong>Hombres:</strong> {{ $hombres }}</p>
        <p class="text-pink-600"><strong>Mujeres:</strong> {{ $mujeres }}</p>
    </div>

    {{-- Listado alumnos --}}
    <h2 class="text-lg sm:text-xl font-semibold mb-3 text-gray-800">Lista de alumnos</h2>

    <div class="overflow-x-auto mb-10">
        <table class="min-w-max w-full border text-xs sm:text-sm">
            <thead class="bg-gray-100 text-gray-700">
                <tr>
                    <th class="border px-3 py-2">Matrícula</th>
                    <th class="border px-3 py-2">Nombre</th>
                    <th class="border px-3 py-2">Género</th>
                    <th class="border px-3 py-2">Carrera</th>
                </tr>
            </thead>

            <tbody>
                @foreach($students as $stu)
                <tr class="hover:bg-gray-50">
                    <td class="border px-3 py-2">{{ $stu->enrollment }}</td>
                    <td class="border px-3 py-2">{{ $stu->name }} {{ $stu->last_name_f }} {{ $stu->last_name_m }}</td>
                    <td class="border px-3 py-2">{{ $stu->gender }}</td>
                    <td class="border px-3 py-2">{{ $stu->career->name }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Reportes --}}
    <h2 class="text-lg sm:text-xl font-semibold mt-8 mb-4 text-gray-800">Reportes del Maestro</h2>

    @if($reports->isEmpty())
        <p class="text-gray-500 italic">No hay reportes disponibles.</p>
    @else
        <div class="space-y-4">
            @foreach($reports as $report)
                @php
                    $path = asset('storage/' . $report->file_path);
                    $ext = strtolower(pathinfo($report->file_path, PATHINFO_EXTENSION));
                @endphp

                <div class="p-4 bg-gray-50 border rounded-lg shadow-sm">

                    <p class="font-semibold text-gray-700">📘 {{ $report->description }}</p>

                    @if($ext === 'pdf')
                        <iframe src="{{ $path }}" class="w-full h-64 mt-3 border rounded-lg"></iframe>
                    @endif

                    @if(in_array($ext, ['jpg','jpeg','png']))
                        <img src="{{ $path }}" class="w-40 h-40 sm:w-48 sm:h-48 object-cover rounded-lg mt-3 border shadow">
                    @endif

                    @if(in_array($ext, ['doc','docx']))
                        <div class="mt-3 flex items-center gap-3">
                            <img src="https://cdn-icons-png.flaticon.com/512/281/281760.png" width="40">
                            <a href="{{ $path }}" target="_blank"
                               class="text-blue-600 underline font-semibold">📄 Descargar archivo Word</a>
                        </div>
                    @endif

                    <a href="{{ $path }}" target="_blank"
                       class="text-blue-600 underline font-semibold mt-2 inline-block">
                        Abrir archivo
                    </a>
                </div>
            @endforeach
        </div>
    @endif

</div>

</main>

<x-basic-sciences-footer />

</body>
</html>



