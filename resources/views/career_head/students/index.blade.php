<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estudiantes de mi Carrera</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

<x-career-head-navbar />

<div class="flex-grow">

    <div class="max-w-[95%] mx-auto bg-white shadow-xl rounded-xl p-8 my-10">

        <h1 class="text-4xl font-extrabold text-[#0B3D7E] mb-6 text-center">
            🎓 Estudiantes de mi Carrera
        </h1>

        {{-- BOTÓN VOLVER Y BUSCADOR --}}
        <div class="flex flex-col md:flex-row md:justify-between gap-4 mb-6">

            <a href="{{ route('career_head.index') }}"
            class="px-4 py-2 w-full md:w-auto rounded-lg bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold text-center">
                ← Volver al inicio
            </a>

            <form class="flex gap-3 w-full md:w-auto" method="GET">
                <input type="text"
                    name="matricula"
                    value="{{ request('matricula') }}"
                    placeholder="Buscar por matrícula..."
                    class="px-4 py-2 border rounded-lg w-full md:w-72 focus:ring-2 focus:ring-[#0B3D7E]">
                <button class="px-4 py-2 bg-[#1ABC9C] text-white rounded-lg">
                    🔍 Buscar
                </button>
            </form>

        </div>

        {{-- TABLA SIN SCROLL HORIZONTAL --}}
        <div class="rounded-xl border shadow">
            <table class="w-full table-auto text-sm">

                <thead class="text-white uppercase font-semibold" style="background-color:#0B3D7E;">
                    <tr>
                        <th class="px-4 py-3">Matrícula</th>
                        <th class="px-4 py-3">Alumno</th>
                        <th class="px-4 py-3 whitespace-nowrap">Semestre</th>
                        <th class="px-4 py-3">Grupo</th>
                        <th class="px-4 py-3">Género</th>
                        <th class="px-4 py-3">Edad</th>
                        <th class="px-4 py-3">Tutor</th>
                        <th class="px-4 py-3 whitespace-nowrap">Horario Escolar</th>

                        {{-- Nuevas columnas --}}
                        <th class="px-4 py-3 whitespace-nowrap">Periodo asesoria</th>
                        <th class="px-4 py-3 whitespace-nowrap">Horario Asesoría</th>
                        <th class="px-4 py-3">Maestro Asesor</th>
                        <th class="px-4 py-3">Materia Asesoría</th>
                    </tr>
                </thead>

                <tbody class="text-gray-800">

                    @foreach ($students as $s)

                        @php
                            $advisory = null;
                            foreach ($s->advisoryDetails as $detail) {
                                if ($detail->status === 'Aprobado' && $detail->advisories->count()) {
                                    $advisory = $detail->advisories->first();
                                }
                            }
                        @endphp

                        <tr class="border-b hover:bg-gray-50 transition">

                            <td class="px-4 py-3 font-medium">{{ $s->enrollment }}</td>

                            <td class="px-4 py-3">
                                {{ $s->name }} {{ $s->last_name_f }} {{ $s->last_name_m }}
                            </td>

                            <td class="px-4 py-3">{{ $s->semester }}</td>
                            <td class="px-4 py-3">{{ $s->group }}</td>
                            <td class="px-4 py-3">{{ $s->gender }}</td>
                            <td class="px-4 py-3">{{ $s->age ?? 'N/D' }}</td>

                            {{-- Tutor --}}
                            <td class="px-4 py-3">
                                @if($s->teacher)
                                    {{ $s->teacher->name }} {{ $s->teacher->last_name_f }}
                                @else
                                    <span class="text-gray-500">Sin tutor</span>
                                @endif
                            </td>

                            {{-- Horario escolar --}}
                            <td class="px-4 py-3">
                                @if ($s->schedule_file)
                                    <a href="{{ asset('storage/'.$s->schedule_file) }}"
                                    target="_blank"
                                    class="text-blue-600 hover:underline">
                                        Ver horario
                                    </a>
                                @else
                                    <span class="text-gray-500">No disponible</span>
                                @endif
                            </td>

                            {{-- Fecha inicio --}}
                            <td class="px-4 py-3">
                                inicio
                                @if($advisory)
                                    {{ \Carbon\Carbon::parse($advisory->start_date)->format('d/m/Y') }}
                                @else
                                    <span class="text-gray-500">—</span>
                                @endif
                                -
                                <br>
                                fin
                                  @if($advisory)
                                    {{ \Carbon\Carbon::parse($advisory->end_date)->format('d/m/Y') }}
                                @else
                                    <span class="text-gray-500">—</span>
                                @endif
                            </td>


                            {{-- Horario asesoría --}}
                            <td class="px-4 py-3 whitespace-nowrap">
                                @if($advisory)
                                    {{ ucfirst($advisory->day_of_week) }}
                                    <br>
                                    {{ \Carbon\Carbon::parse($advisory->start_time)->format('H:i') }}
                                    –
                                    {{ \Carbon\Carbon::parse($advisory->end_time)->format('H:i') }}
                                @else
                                    <span class="text-gray-500">—</span>
                                @endif
                            </td>

                            {{-- Maestro asesor --}}
                            <td class="px-4 py-3">
                                @if($advisory)
                                    {{ $advisory->teacherSubject->teacher->name }}
                                    {{ $advisory->teacherSubject->teacher->last_name_f }}
                                @else
                                    <span class="text-gray-500">—</span>
                                @endif
                            </td>

                            {{-- Materia --}}
                            <td class="px-4 py-3">
                                @if($advisory)
                                    {{ $advisory->teacherSubject->subject->name }}
                                @else
                                    <span class="text-gray-500">—</span>
                                @endif
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>
        </div>
    </div>

</div>

<x-basic-sciences-footer />

</body>
</html>
