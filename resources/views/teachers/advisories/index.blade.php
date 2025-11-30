<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Asesorías</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- NAVBAR --}}
    <div class="fixed top-0 left-0 w-full z-50 shadow">
        <x-teachers-navbar />
    </div>

<main class="flex-1 mt-28 mb-20 px-4">

<div class="max-w-7xl mx-auto bg-white shadow-xl rounded-xl p-6 sm:p-8">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">
        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0B3D7E]">
            📅 Mis Asesorías Programadas
        </h1>

        <a href="{{ route('teachers.index') }}"
           class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg font-semibold">
            ← Volver al panel
        </a>
    </div>

    {{-- SIN ASESORÍAS --}}
    @if ($advisories->count() == 0)
        <p class="text-center text-gray-600 text-lg py-8">
            No tienes asesorías asignadas.
        </p>
    @else

    {{-- TABLA --}}
    <div class="overflow-x-auto rounded-xl border border-gray-200 shadow">

        <table class="min-w-full text-xs sm:text-sm">

            <thead class="text-white uppercase font-semibold"
                   style="background-color:#0B3D7E;">
                <tr>
                    <th class="px-4 py-3 whitespace-nowrap">Fecha</th>
                    <th class="px-4 py-3 whitespace-nowrap">Horario</th>
                    <th class="px-4 py-3 whitespace-nowrap">Materia</th>
                    <th class="px-4 py-3 whitespace-nowrap">Carrera</th>
                    <th class="px-4 py-3 whitespace-nowrap text-center">Alumnos</th>
                    <th class="px-4 py-3 whitespace-nowrap">Aula</th>
                    <th class="px-4 py-3 whitespace-nowrap">Edificio</th>
                    <th class="px-4 py-3 whitespace-nowrap">Estado</th>
                    <th class="px-4 py-3 whitespace-nowrap text-center">Ficha</th>
                    <th class="px-4 py-3 whitespace-nowrap text-center">Acciones</th>
                </tr>
            </thead>

            <tbody class="text-gray-800">

                @foreach ($advisories as $adv)

                    @php
                        $startDate = \Carbon\Carbon::parse($adv->start_date)->format('d/m/Y');
                        $endDate   = \Carbon\Carbon::parse($adv->end_date)->format('d/m/Y');
                        $startTime = \Carbon\Carbon::parse($adv->start_time)->format('H:i');
                        $endTime   = \Carbon\Carbon::parse($adv->end_time)->format('H:i');
                        $day = ucfirst($adv->day_of_week);
                    @endphp

                    <tr class="border-b hover:bg-gray-100 transition">

                        {{-- Fecha --}}
                        <td class="px-4 py-3 font-semibold whitespace-nowrap">
                            📅 {{ $startDate }} – {{ $endDate }}
                        </td>

                        {{-- Horario --}}
                        <td class="px-4 py-3 font-semibold whitespace-nowrap">
                            🕒 {{ $day }} {{ $startTime }} – {{ $endTime }}
                        </td>

                        {{-- Materia --}}
                        <td class="px-4 py-3 font-semibold whitespace-nowrap">
                            {{ $adv->materiaSolicitada }}
                        </td>

                        {{-- Carrera --}}
                        <td class="px-4 py-3 whitespace-nowrap">
                            {{ $adv->carreraSolicitada }}
                        </td>

                        {{-- Alumnos --}}
                        <td class="px-4 py-3 text-center font-bold whitespace-nowrap">
                            {{ $adv->advisoryDetail->students->count() }}
                        </td>

                        {{-- Aula --}}
                        <td class="px-4 py-3 whitespace-nowrap">
                            {{ $adv->classroom ?? '---' }}
                        </td>

                        {{-- Edificio --}}
                        <td class="px-4 py-3 whitespace-nowrap">
                            {{ $adv->building ?? '---' }}
                        </td>

                        {{-- Estado --}}
                        <td class="px-4 py-3 whitespace-nowrap">
                            <span class="px-3 py-1 rounded-full text-white text-xs font-semibold
                                @if($adv->advisoryDetail->status == 'Pendiente') bg-yellow-600
                                @elseif($adv->advisoryDetail->status == 'Aprobado') bg-green-600
                                @else bg-red-600 @endif">
                                {{ $adv->advisoryDetail->status }}
                            </span>
                        </td>

                        {{-- Archivo --}}
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            @if ($adv->assignment_file)
                                <a href="{{ asset('storage/'.$adv->assignment_file) }}"
                                   target="_blank"
                                   class="text-blue-600 hover:underline font-medium">
                                    📄 Ver archivo
                                </a>
                            @else
                                <span class="text-gray-500">---</span>
                            @endif
                        </td>

                        {{-- Acciones --}}
                        <td class="px-4 py-3 text-center whitespace-nowrap">
                            <div class="flex flex-col sm:flex-row gap-2 justify-center">

                                <a href="{{ route('teachers.advisories.reports.by_advisory', $adv->advisory_id) }}"
                                   class="px-3 py-1 bg-blue-600 text-white rounded-lg shadow font-semibold hover:bg-blue-700">
                                    📄 Reportes
                                </a>

                                <a href="{{ route('teachers.advisories.reports.create', $adv->advisory_id) }}"
                                   class="px-3 py-1 bg-green-600 text-white rounded-lg shadow font-semibold hover:bg-green-700">
                                    ⬆️ Subir
                                </a>

                            </div>
                        </td>

                    </tr>

                @endforeach

            </tbody>

        </table>

    </div>

    {{-- PAGINACIÓN --}}
    <div class="mt-6 flex justify-center">
        {{ $advisories->links('vendor.pagination.tailwind') }}
    </div>

    @endif

</div>

</main>

<x-basic-sciences-footer />

</body>
</html>
