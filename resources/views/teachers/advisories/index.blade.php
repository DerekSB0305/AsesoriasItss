<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Asesorías</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen p-6">

<div class="max-w-6xl mx-auto bg-white shadow-lg rounded-xl p-8">

    {{-- Título --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">📅 Mis Asesorías Programadas</h1>

        <a href="{{ route('teachers.index') }}"
           class="text-green-600 hover:text-green-800 font-medium">
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
            <table class="w-full border-collapse rounded-lg overflow-hidden shadow-sm">

                <thead class="bg-gray-200 text-gray-700 text-sm uppercase">
                    <tr>
                        <th class="px-4 py-3">Fecha</th>
                        <th class="px-4 py-3">Hora</th>
                        <th class="px-4 py-3">Materia</th>
                        <th class="px-4 py-3">Carrera</th>
                        <th class="px-4 py-3 text-center">Alumnos</th>
                        <th class="px-4 py-3">Aula</th>
                        <th class="px-4 py-3">Edificio</th>
                        <th class="px-4 py-3">Estado</th>
                        <th class="px-4 py-3 text-center">Ficha de asignación</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700">

                    @foreach ($advisories as $adv)
                        @php
                            $students = $adv->advisoryDetail->students ?? collect();
                            $date = \Carbon\Carbon::parse($adv->schedule)->format('Y-m-d');
                            $time = \Carbon\Carbon::parse($adv->schedule)->format('H:i');
                        @endphp

                        <tr class="border-b hover:bg-gray-50 transition">

                            <td class="px-4 py-3">{{ $date }}</td>
                            <td class="px-4 py-3">{{ $time }} hrs</td>

                            <td class="px-4 py-3 font-semibold">
                                {{ $adv->teacherSubject->subject->name }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $adv->teacherSubject->subject->career->name }}
                            </td>

                            <td class="px-4 py-3 text-center font-bold">
                                {{ $students->count() }}
                            </td>

                            <td class="px-4 py-3">{{ $adv->classroom ?? '---' }}</td>

                            <td class="px-4 py-3">{{ $adv->building ?? '---' }}</td>

                            <td class="px-4 py-3">
                                <span class="px-3 py-1 rounded text-white text-sm
                                    @if($adv->advisoryDetail->status == 'Pending') bg-yellow-500
                                    @elseif($adv->advisoryDetail->status == 'Approved') bg-green-600
                                    @else bg-gray-600 @endif">
                                    {{ $adv->advisoryDetail->status }}
                                </span>
                            </td>

                            <td class="px-4 py-3 text-center">
                                @if ($adv->assignment_file)
                                    <a href="{{ asset('storage/'.$adv->assignment_file) }}"
                                        target="_blank"
                                        class="text-blue-600 hover:underline">
                                        Ver archivo
                                    </a>
                                @else
                                    <span class="text-gray-500">---</span>
                                @endif
                            </td>
                            <td class="px-4 py-3 text-center">

                        {{-- VER REPORTES --}}
                        <a href="{{ route('teachers.advisories.reports.by_advisory', $adv->advisory_id) }}"
                        class="bg-indigo-900 text-white px-3 py-1 rounded hover:bg-indigo-700">
                            Ver reportes
                        </a>

                        <br>

                        <a href="{{ route('teachers.advisories.reports.create', $adv->advisory_id) }}"
                        class="bg-indigo-600 text-white px-3 py-1 rounded hover:bg-indigo-700 transition">
                            Subir reporte
                        </a>

                    </td>


                            

                        </tr>
                    @endforeach

                </tbody>
            </table>
        </div>

    @endif

</div>

</body>
</html>
