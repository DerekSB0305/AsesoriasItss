<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asesorías de mi Carrera</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

{{-- NAVBAR --}}
<x-career-head-navbar />

<div class="max-w-7xl mx-auto bg-white shadow-xl rounded-xl p-8 my-10 flex-1 w-full">

    <h1 class="text-4xl font-extrabold text-[#0B3D7E] mb-8 text-center">
        🧩 Asesorías de Maestros de mi Carrera
    </h1>

    {{-- 🔙 Botón volver + buscador --}}
    <div class="flex flex-col md:flex-row md:justify-between gap-4 mb-8">

        <a href="{{ route('career_head.index') }}"
           class="px-4 py-2 rounded-lg bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold text-center">
            ← Volver al inicio
        </a>

        <form method="GET" class="flex gap-3 w-full md:w-auto">

            <input type="text" name="maestro" value="{{ request('maestro') }}"
                   placeholder="Buscar por maestro..."
                   class="px-4 py-2 border rounded-lg w-full md:w-72 focus:ring-2 focus:ring-[#0B3D7E]">

            <select name="estado"
                    class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#0B3D7E]">
                <option value="">Estado</option>
                <option value="Pendiente" {{ request('estado')=='Pendiente'?'selected':'' }}>Pendiente</option>
                <option value="Aprobado" {{ request('estado')=='Aprobado'?'selected':'' }}>Aprobado</option>
                <option value="Finalizado" {{ request('estado')=='Finalizado'?'selected':'' }}>Finalizado</option>
            </select>

            <button class="px-4 py-2 bg-[#1ABC9C] text-white rounded-lg shadow">
                🔍 Buscar
            </button>

        </form>
    </div>

    {{-- 📋 TABLA DE ASESORÍAS --}}
    <div class="overflow-x-auto rounded-xl border shadow">
        <table class="w-full border-collapse text-sm">

            <thead class="text-white uppercase font-semibold" style="background-color:#0B3D7E;">
                <tr>
                    <th class="px-4 py-3">Maestro</th>
                    <th class="px-4 py-3">Carrera</th>
                    <th class="px-4 py-3">Materia</th>
                    <th class="px-4 py-3">Fechas</th>
                    <th class="px-4 py-3">Día & Horario</th>
                    <th class="px-4 py-3">Aula</th>
                    <th class="px-4 py-3">Edificio</th>
                    <th class="px-4 py-3">Alumnos</th>
                    <th class="px-4 py-3">Estado</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
            </thead>

            <tbody class="text-gray-800">

                @foreach ($advisories as $a)

                    @php
                        $teacher = $a->teacherSubject->teacher;
                        $subject = $a->teacherSubject->subject;
                        $career  = $a->teacherSubject->career;
                        $detail  = $a->advisoryDetail;
                    @endphp

                    <tr class="border-b hover:bg-gray-50 transition">

                        {{-- Maestro --}}
                        <td class="px-4 py-3 font-semibold">
                            {{ $teacher->name }} {{ $teacher->last_name_f }}
                        </td>

                        {{-- Carrera --}}
                        <td class="px-4 py-3">
                            {{ $career->name }}
                        </td>

                        {{-- Materia --}}
                        <td class="px-4 py-3">
                            {{ $subject->name }}
                        </td>

                        {{-- Fechas inicio/fin --}}
                        <td class="px-4 py-3">
                            {{ \Carbon\Carbon::parse($a->start_date)->format('d/m/Y') }} <br>
                            <span class="text-gray-500">a</span> <br>
                            {{ \Carbon\Carbon::parse($a->end_date)->format('d/m/Y') }}
                        </td>

                        {{-- Día y horario --}}
                        <td class="px-4 py-3">
                            {{ ucfirst($a->day_of_week) }}<br>
                            {{ \Carbon\Carbon::parse($a->start_time)->format('H:i') }} -
                            {{ \Carbon\Carbon::parse($a->end_time)->format('H:i') }}
                        </td>

                        {{-- Aula --}}
                        <td class="px-4 py-3">
                            {{ $a->classroom ?? 'N/A' }}
                        </td>

                        {{-- Edificio --}}
                        <td class="px-4 py-3">
                            {{ $a->building ?? 'N/A' }}
                        </td>

                        {{-- Total de alumnos --}}
                        <td class="px-4 py-3 text-center font-bold">
                            {{ $detail->students->count() }}
                        </td>

                        {{-- Estado --}}
                        <td class="px-4 py-3 font-semibold">

                            @if($detail->status == 'Pendiente')
                                <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded">Pendiente</span>
                            @elseif($detail->status == 'Aprobado')
                                <span class="px-2 py-1 bg-green-100 text-green-700 rounded">Aprobado</span>
                            @else
                                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded">Finalizado</span>
                            @endif

                        </td>

                        {{-- Acciones --}}
                        <td class="px-4 py-3 text-center">
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

{{-- FOOTER --}}
<x-basic-sciences-footer />

</body>
</html>
