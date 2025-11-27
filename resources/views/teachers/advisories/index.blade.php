<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Asesorías</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

<x-teachers-navbar/>

<div class="flex-grow p-6">

<div class="max-w-6xl mx-auto bg-white shadow-xl rounded-2xl p-8">

    {{-- Título --}}
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between mb-6 gap-3">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">📅 Mis Asesorías Programadas</h1>

        <a href="{{ route('teachers.index') }}"
           class="text-green-600 hover:text-green-800 font-semibold">
            ← Volver al panel
        </a>
    </div>

    {{-- Si no tiene asesorías --}}
    @if ($advisories->count() == 0)
        <p class="text-center text-gray-600 py-6 text-lg">
            No tienes asesorías asignadas.
        </p>
    @else

        {{-- Tabla --}}
        <div class="overflow-x-auto">

            <table class="min-w-full border-collapse rounded-lg overflow-hidden shadow">

                <thead class="text-white uppercase text-xs font-semibold" style="background-color:#0B3D7E;">
                    <tr>
                        <th class="px-4 py-3">Fecha</th>
                        <th class="px-4 py-3">Hora</th>
                        <th class="px-4 py-3">Materia</th>
                        <th class="px-4 py-3">Carrera</th>
                        <th class="px-4 py-3 text-center">Alumnos</th>
                        <th class="px-4 py-3">Aula</th>
                        <th class="px-4 py-3">Edificio</th>
                        <th class="px-4 py-3">Estado</th>
                        <th class="px-4 py-3 text-center">Ficha</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700">

                    @foreach ($advisories as $adv)
                        @php
                            // Fechas
                            $startDate = \Carbon\Carbon::parse($adv->start_date)->format('d/m/Y');
                            $endDate   = \Carbon\Carbon::parse($adv->end_date)->format('d/m/Y');

                            // Horas
                            $startTime = \Carbon\Carbon::parse($adv->start_time)->format('H:i');
                            $endTime   = \Carbon\Carbon::parse($adv->end_time)->format('H:i');

                            // Día
                            $day = ucfirst($adv->day_of_week);
                        @endphp

                        <tr class="border-b hover:bg-gray-50 transition">

                            {{-- Fecha --}}
                            <td class="px-4 py-3 font-semibold">
                                📅 Del {{ $startDate }} al {{ $endDate }}
                            </td>

                            {{-- Hora --}}
                            <td class="px-4 py-3 font-semibold">
                                🕒 {{ $day }} {{ $startTime }} - {{ $endTime }}
                            </td>

                            {{-- Materia --}}
                            <td class="px-4 py-3 font-semibold">
                                {{ $adv->teacherSubject->subject->name }}
                            </td>

                            {{-- Carrera --}}
                            <td class="px-4 py-3">
                                {{ $adv->teacherSubject->subject->career->name }}
                            </td>

                            {{-- Alumnos --}}
                            <td class="px-4 py-3 text-center font-bold">
                                {{ optional($adv->advisoryDetail->students)->count() ?? 0 }}
                            </td>

                            {{-- Aula --}}
                            <td class="px-4 py-3">{{ $adv->classroom ?? '---' }}</td>

                            {{-- Edificio --}}
                            <td class="px-4 py-3">{{ $adv->building ?? '---' }}</td>

                            {{-- Estado --}}
                            <td class="px-4 py-3">
                                <span class="px-3 py-1 rounded-full text-white text-xs font-semibold
                                    @if($adv->advisoryDetail->status == 'Pending') bg-yellow-600
                                    @elseif($adv->advisoryDetail->status == 'Aprobado') bg-green-600
                                    @else bg-red-600 @endif">
                                    {{ $adv->advisoryDetail->status }}
                                </span>
                            </td>

                            {{-- Archivo --}}
                            <td class="px-4 py-3 text-center">
                                @if ($adv->assignment_file)
                                    <a href="{{ asset('storage/'.$adv->assignment_file) }}"
                                       target="_blank"
                                       class="text-blue-600 hover:underline font-medium">
                                        Ver archivo
                                    </a>
                                @else
                                    <span class="text-gray-500">---</span>
                                @endif
                            </td>

                            {{-- Acciones --}}
                            <td class="px-4 py-3 text-center space-y-2">

                                {{-- VER REPORTES --}}
                                <a href="{{ route('teachers.advisories.reports.by_advisory', $adv->advisory_id) }}"
                                   class="inline-flex items-center justify-center w-full sm:w-auto 
                                          bg-blue-600 text-white px-4 py-2 rounded-lg font-medium
                                          shadow hover:bg-blue-700 transition">
                                    📄 Ver reportes
                                </a>

                                {{-- SUBIR REPORTE --}}
                                <a href="{{ route('teachers.advisories.reports.create', $adv->advisory_id) }}"
                                   class="inline-flex items-center justify-center w-full sm:w-auto
                                          bg-green-600 text-white px-4 py-2 rounded-lg font-medium
                                          shadow hover:bg-green-700 transition">
                                    ⬆️ Subir reporte
                                </a>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

        </div>

    @endif

</div>
</div>

<x-basic-sciences-footer/>

</body>
</html>
