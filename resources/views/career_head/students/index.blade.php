<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Estudiantes de mi Carrera</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

<x-basic-sciences-navbar />

<div class="max-w-6xl mx-auto bg-white shadow-lg rounded-xl p-8 my-10">

    <h1 class="text-3xl font-bold text-[#0B3D7E] mb-6">
        🎓 Estudiantes de mi Carrera
    </h1>

    <div class="overflow-x-auto">
        <table class="w-full border-collapse shadow">

            <thead style="background-color:#0B3D7E;" class="text-white font-bold">
                <tr>
                    <th class="px-4 py-3 text-left">Matrícula</th>
                    <th class="px-4 py-3 text-left">Nombre</th>
                    <th class="px-4 py-3 text-left">Apellido Paterno</th>
                    <th class="px-4 py-3 text-left">Apellido Materno</th>
                    <th class="px-4 py-3 text-left">Carrera</th>
                    <th class="px-4 py-3 text-left">Semestre</th>
                    <th class="px-4 py-3 text-left">Grupo</th>
                    <th class="px-4 py-3 text-left">Género</th>
                    <th class="px-4 py-3 text-left">Edad</th>
                    <th class="px-4 py-3 text-left">Maestro tutor</th>
                    <th class="px-4 py-3 text-left">Horario</th>
                    <th class="px-4 py-3 text-left">Horario de asesoría</th>
                </tr>
            </thead>

            <tbody class="text-gray-700">

                @foreach ($students as $s)
                    @php
                        // colección de detalles de asesoría (si algo fallara, caemos a collect())
                        $details = $s->advisoryDetails ?? collect();
                        $lastDetail = $details->last();
                    @endphp

                    <tr class="border-b hover:bg-gray-50 transition">

                        <td class="px-4 py-3">{{ $s->enrollment }}</td>
                        <td class="px-4 py-3">{{ $s->name }}</td>
                        <td class="px-4 py-3">{{ $s->last_name_f }}</td>
                        <td class="px-4 py-3">{{ $s->last_name_m }}</td>

                        <td class="px-4 py-3">
                            {{ $s->career->name ?? 'Sin carrera' }}
                        </td>

                        <td class="px-4 py-3">{{ $s->semester }}</td>
                        <td class="px-4 py-3">{{ $s->group }}</td>
                        <td class="px-4 py-3">{{ $s->gender }}</td>
                        <td class="px-4 py-3">{{ $s->age ?? 'N/D' }}</td>

                        {{-- Maestro tutor --}}
                        <td class="px-4 py-3">
                            @if ($s->teacher)
                                {{ $s->teacher->name }} {{ $s->teacher->last_name_f }}
                            @else
                                <span class="text-gray-500">Sin tutor</span>
                            @endif
                        </td>

                        {{-- Horario escolar --}}
                        <td class="px-4 py-3">
                            @if ($s->schedule_file)
                                <a href="{{ asset('storage/' . $s->schedule_file) }}"
                                   target="_blank"
                                   class="text-blue-600 hover:underline">
                                    Ver horario
                                </a>
                            @else
                                <span class="text-gray-500">No disponible</span>
                            @endif
                        </td>

                        {{-- Horario de asesoría (última asesoría si existe) --}}
                        <td class="px-4 py-3">
                            @if ($lastDetail && $lastDetail->advisories && $lastDetail->advisories->count())
                                {{-- por si un detalle tiene varias asesorías, tomamos la última --}}
                                @php
                                    $lastAdvisory = $lastDetail->advisories->last();
                                @endphp

                                @if ($lastAdvisory && $lastAdvisory->schedule)
                                    {{ $lastAdvisory->schedule }}
                                @else
                                    <span class="text-gray-500">Sin horario registrado</span>
                                @endif
                            @else
                                <span class="text-gray-500">Sin asesorías</span>
                            @endif
                        </td>

                    </tr>
                @endforeach

            </tbody>

        </table>
    </div>
</div>

<x-basic-sciences-footer />

</body>
</html>


