<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asesorías de mi Carrera</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

<x-career-head-navbar />

<main class="flex-grow">

<div class="w-[95%] max-w-7xl mx-auto bg-white shadow-lg rounded-xl p-4 sm:p-6 md:p-8 my-8">

    <h1 class="text-2xl sm:text-3xl md:text-4xl font-extrabold text-[#0B3D7E] mb-6 text-center">
        🧩 Asesorías de Maestros de mi Carrera
    </h1>

    <div class="flex flex-col md:flex-row md:justify-between gap-4 mb-6">

        <a href="{{ route('career_head.index') }}"
           class="px-4 py-2 rounded-lg bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold text-center">
            ← Volver al inicio
        </a>

        <form method="GET" class="flex flex-col sm:flex-row gap-3 w-full md:w-auto">

            <input type="text" name="maestro" value="{{ request('maestro') }}"
                   placeholder="Buscar por maestro..."
                   class="px-3 py-2 border rounded-lg w-full sm:w-64 md:w-72 focus:ring-2 focus:ring-[#0B3D7E]">

            <select name="estado"
                    class="px-3 py-2 border rounded-lg focus:ring-2 focus:ring-[#0B3D7E] w-full sm:w-auto">
                <option value="">Estado</option>
                <option value="Pendiente" {{ request('estado')=='Pendiente'?'selected':'' }}>Pendiente</option>
                <option value="Aprobado" {{ request('estado')=='Aprobado'?'selected':'' }}>Aprobado</option>
                <option value="Finalizado" {{ request('estado')=='Finalizado'?'selected':'' }}>Finalizado</option>
            </select>

            <button class="px-4 py-2 bg-[#1ABC9C] text-white rounded-lg shadow w-full sm:w-auto">
                🔍 Buscar
            </button>

        </form>
    </div>

    <div class="overflow-x-auto rounded-xl border shadow">

        <table class="min-w-max w-full border-collapse text-sm sm:text-base">

            <thead class="text-white uppercase font-semibold" style="background-color:#0B3D7E;">
                <tr>
                    <th class="px-4 py-3 whitespace-nowrap">Maestro</th>
                    <th class="px-4 py-3 whitespace-nowrap">Carrera solicitada</th>
                    <th class="px-4 py-3 whitespace-nowrap">Materia solicitada</th>
                    <th class="px-4 py-3 whitespace-nowrap">Fechas</th>
                    <th class="px-4 py-3 whitespace-nowrap">Día & Horario</th>
                    <th class="px-4 py-3 whitespace-nowrap">Aula</th>
                    <th class="px-4 py-3 whitespace-nowrap">Edificio</th>
                    <th class="px-4 py-3 whitespace-nowrap">Alumnos</th>
                    <th class="px-4 py-3 whitespace-nowrap">Estado</th>
                    <th class="px-4 py-3 text-center whitespace-nowrap">Detalles</th>
                </tr>
            </thead>

            <tbody class="text-gray-800">

                @foreach ($advisories as $a)

                    @php
                        // Maestro
                        $teacher = $a->teacherSubject->teacher;

                        // Solicitud (materia y carrera REAL solicitada)
                        $solicitud = $a->advisoryDetail->requests->first();
                        $materiaSolicitada = $solicitud?->subject?->name ?? 'N/A';
                        $carreraSolicitada = $solicitud?->subject?->career?->name ?? 'Materia común';

                        // Fechas y horas
                        $startDate = \Carbon\Carbon::parse($a->start_date)->format('d/m/Y');
                        $endDate   = \Carbon\Carbon::parse($a->end_date)->format('d/m/Y');
                        $startTime = \Carbon\Carbon::parse($a->start_time)->format('H:i');
                        $endTime   = \Carbon\Carbon::parse($a->end_time)->format('H:i');

                        $detail = $a->advisoryDetail;
                    @endphp

                    <tr class="border-b hover:bg-gray-50 transition">

                        {{-- Maestro --}}
                        <td class="px-4 py-3 font-semibold whitespace-nowrap">
                            {{ $teacher->name }} {{ $teacher->last_name_f }}
                        </td>

                        {{-- Carrera solicitada --}}
                        <td class="px-4 py-3 whitespace-nowrap">
                            {{ $carreraSolicitada }}
                        </td>

                        {{-- Materia solicitada --}}
                        <td class="px-4 py-3 whitespace-nowrap">
                            {{ $materiaSolicitada }}
                        </td>

                        {{-- Fechas --}}
                        <td class="px-4 py-3 whitespace-nowrap">
                            {{ $startDate }} <br>
                            <span class="text-gray-500">a</span> <br>
                            {{ $endDate }}
                        </td>

                        {{-- Día y horario --}}
                        <td class="px-4 py-3 whitespace-nowrap">
                            {{ ucfirst($a->day_of_week) }}<br>
                            {{ $startTime }} - {{ $endTime }}
                        </td>

                        {{-- Aula --}}
                        <td class="px-4 py-3 whitespace-nowrap">
                            {{ $a->classroom ?? 'N/A' }}
                        </td>

                        {{-- Edificio --}}
                        <td class="px-4 py-3 whitespace-nowrap">
                            {{ $a->building ?? 'N/A' }}
                        </td>

                        {{-- Alumnos --}}
                        <td class="px-4 py-3 text-center font-bold whitespace-nowrap">
                            {{ $detail->students->count() }}
                        </td>

                        {{-- Estado --}}
                        <td class="px-4 py-3 font-semibold whitespace-nowrap">
                            @if($detail->status == 'Pendiente')
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded">Pendiente</span>
                            @elseif($detail->status == 'Aprobado')
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded">Aprobado</span>
                            @else
                                <span class="px-2 py-1 bg-red-600 text-white  rounded">Finalizado</span>
                            @endif
                        </td>

                        {{-- Detalles --}}
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                           <a href="{{ route('career_head.advisories.details', $a->advisory_id) }}"
                               class="text-indigo-600 hover:text-indigo-800 font-semibold">
                                📄 Ver detalles
                            </a>
                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

</div>

</main>

<x-basic-sciences-footer />

</body>
</html>
