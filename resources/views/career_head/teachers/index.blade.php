<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Maestros de mi Carrera</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

<x-career-head-navbar />

<div class="max-w-7xl mx-auto bg-white shadow-xl rounded-xl p-8 my-10 flex-grow">

    <h1 class="text-4xl font-extrabold text-[#0B3D7E] mb-6 text-center">
        👨‍🏫 Maestros de mi Carrera
    </h1>

    <!-- BUSCADOR -->
    <div class="flex flex-col md:flex-row md:justify-between gap-4 mb-6">

        <a href="{{ route('career_head.index') }}"
           class="px-4 py-2 w-full md:w-auto rounded-lg bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold text-center">
            ← Volver al inicio
        </a>

        <form class="flex flex-wrap gap-3 w-full md:w-auto" method="GET">

            <input type="text"
                   name="nombre"
                   value="{{ request('nombre') }}"
                   placeholder="Buscar nombre..."
                   class="px-3 py-2 border rounded-lg w-full md:w-64 focus:ring-2 focus:ring-[#0B3D7E]">

            <select name="tutor"
                    class="px-3 py-2 border rounded-lg focus:ring-[#0B3D7E]">
                <option value="">Tutor</option>
                <option value="1" {{ request('tutor') === "1" ? 'selected' : '' }}>Sí</option>
                <option value="0" {{ request('tutor') === "0" ? 'selected' : '' }}>No</option>
            </select>

            <select name="cb"
                    class="px-3 py-2 border rounded-lg focus:ring-[#0B3D7E]">
                <option value="">Horas CB</option>
                <option value="1" {{ request('cb') === "1" ? 'selected' : '' }}>Sí</option>
                <option value="0" {{ request('cb') === "0" ? 'selected' : '' }}>No</option>
            </select>

            <button class="px-4 py-2 bg-[#1ABC9C] text-white rounded-lg">
                🔍 Buscar
            </button>
        </form>

    </div>

    <div class="overflow-x-auto rounded-xl border shadow">
        <table class="w-full border-collapse text-sm">

            <thead class="text-white uppercase font-semibold text-center" style="background-color:#0B3D7E;">
            <tr>
                <th class="px-3 py-3">Usuario</th>
                <th class="px-3 py-3">Nombre</th>
                <th class="px-3 py-3">Carrera</th>
                <th class="px-3 py-3">Grado</th>
                <th class="px-3 py-3">Tutor</th>
                <th class="px-3 py-3">Horas CB</th>
                <th class="px-3 py-3">Horario Escolar</th>

                <!-- Nuevas columnas -->
                <th class="px-3 py-3">Fechas Asesoría</th>
                <th class="px-3 py-3">Horario Asesoría</th>
                <th class="px-3 py-3">Materia</th>
            </tr>
            </thead>

            <tbody class="text-gray-700">

            @foreach ($teachers as $t)

                @php
                    $as = null;

                    if ($t->teacherSubjects->count()) {
                        foreach ($t->teacherSubjects as $ts) {
                            if ($ts->advisories->count()) {
                                $as = $ts->advisories->last();
                            }
                        }
                    }
                @endphp

                <tr class="border-b hover:bg-gray-50 transition text-center">

                    <td class="px-3 py-3">{{ $t->teacher_user }}</td>

                    <td class="px-3 py-3 font-semibold">
                        {{ $t->name }} {{ $t->last_name_f }} {{ $t->last_name_m }}
                    </td>

                    <td class="px-3 py-3">{{ $t->career->name ?? 'N/A' }}</td>

                    <td class="px-3 py-3">{{ $t->degree }}</td>

                    <td class="px-3 py-3">{{ $t->tutor ? 'Sí' : 'No' }}</td>

                    <td class="px-3 py-3">{{ $t->science_department ? 'Sí' : 'No' }}</td>

                    <td class="px-3 py-3">
                        @if($t->schedule)
                            <a href="{{ asset('storage/'.$t->schedule) }}"
                               target="_blank"
                               class="text-blue-600 font-semibold hover:text-blue-800">
                                📄 Ver
                            </a>
                        @else
                            <span class="text-gray-500">No disponible</span>
                        @endif
                    </td>

                    <!-- Columna rango de fechas -->
                    <td class="px-3 py-3">
                        @if($as)
                            {{ \Carbon\Carbon::parse($as->start_date)->format('d/m/Y') }}
                            -
                            {{ \Carbon\Carbon::parse($as->end_date)->format('d/m/Y') }}
                        @else
                            <span class="text-gray-400">—</span>
                        @endif
                    </td>

                    <!-- Horario asesoría -->
                    <td class="px-3 py-3">
                        @if($as)
                            {{ ucfirst($as->day_of_week) }}<br>
                            {{ \Carbon\Carbon::parse($as->start_time)->format('H:i') }}
                            –
                            {{ \Carbon\Carbon::parse($as->end_time)->format('H:i') }}
                        @else
                            <span class="text-gray-400">—</span>
                        @endif
                    </td>

                    <!-- Materia -->
                    <td class="px-3 py-3">
                        @if($as)
                            {{ $as->teacherSubject->subject->name }}
                        @else
                            <span class="text-gray-400">—</span>
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
