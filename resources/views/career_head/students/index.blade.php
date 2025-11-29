<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estudiantes de mi Carrera</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

<x-career-head-navbar />

<main class="flex-grow">

<div class="w-[95%] max-w-7xl mx-auto bg-white shadow-lg rounded-xl p-6 sm:p-8 my-10">

    <!-- TÍTULO -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-[#0B3D7E] text-center sm:text-left">
            🎓 Estudiantes de mi Carrera
        </h1>

        <a href="{{ route('career_head.index') }}"
            class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg font-semibold text-center">
            ← Volver al inicio
        </a>
    </div>

    <form method="GET"
        class="bg-gray-50 p-4 rounded-lg shadow mb-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

        <div>
            <label class="text-sm font-semibold">Matrícula</label>
            <input type="text" name="matricula" value="{{ request('matricula') }}"
                class="w-full px-3 py-2 border rounded-lg focus:ring-[#0B3D7E]"
                placeholder="Ej. 22451234">
        </div>

        <div>
            <label class="text-sm font-semibold">Semestre</label>
            <select name="semestre"
                class="w-full px-3 py-2 border rounded-lg focus:ring-[#0B3D7E]">
                <option value="">Todos</option>
                @for($i=1; $i<=12; $i++)
                    <option value="{{ $i }}" {{ request('semestre') == $i ? 'selected' : '' }}>
                        {{ $i }}
                    </option>
                @endfor
            </select>
        </div>

        <div>
            <label class="text-sm font-semibold">Grupo</label>
            <input type="text" name="grupo" value="{{ request('grupo') }}"
                class="w-full px-3 py-2 border rounded-lg focus:ring-[#0B3D7E]"
                placeholder="Ej. A, B, C">
        </div>

        <div class="flex items-end">
            <button class="px-6 py-2 bg-[#1ABC9C] text-white rounded-lg shadow hover:bg-[#159a82] w-full">
                🔍 Buscar
            </button>
        </div>

    </form>

    <div class="overflow-x-auto">

        <table class="min-w-max w-full border-collapse shadow text-sm sm:text-base">

            <thead style="background-color:#0B3D7E;" class="text-white font-bold">
                <tr>
                    <th class="px-3 py-2">Matrícula</th>
                    <th class="px-3 py-2 whitespace-nowrap">Alumno</th>
                    <th class="px-3 py-2">Semestre</th>
                    <th class="px-3 py-2">Grupo</th>
                    <th class="px-3 py-2">Género</th>
                    <th class="px-3 py-2">Edad</th>
                    <th class="px-3 py-2 whitespace-nowrap">Tutor</th>
                    <th class="px-3 py-2 whitespace-nowrap">Horario Escolar</th>
                    <th class="px-3 py-2 whitespace-nowrap text-center">Periodo Asesoría</th>
                    <th class="px-3 py-2 whitespace-nowrap text-center">Horario Asesoría</th>
                    <th class="px-3 py-2 whitespace-nowrap">Maestro Asesor</th>
                    <th class="px-3 py-2 whitespace-nowrap">Materia Asesoría</th>
                </tr>
            </thead>

            <tbody class="text-gray-700">

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

                        <td class="px-3 py-2 font-semibold">{{ $s->enrollment }}</td>

                        <td class="px-3 py-2 whitespace-nowrap">
                            {{ $s->name }} {{ $s->last_name_f }} {{ $s->last_name_m }}
                        </td>

                        <td class="px-3 py-2 text-center">{{ $s->semester }}</td>
                        <td class="px-3 py-2 text-center">{{ $s->group }}</td>
                        <td class="px-3 py-2 text-center">{{ $s->gender }}</td>
                        <td class="px-3 py-2 text-center">{{ $s->age ?? 'N/D' }}</td>

                        <td class="px-3 py-2 whitespace-nowrap">
                            @if($s->teacher)
                                {{ $s->teacher->name }} {{ $s->teacher->last_name_f }}
                            @else
                                <span class="text-gray-500">Sin tutor</span>
                            @endif
                        </td>

                        <td class="px-3 py-2 text-center">
                            @if ($s->schedule_file)
                                <a href="{{ asset('storage/'.$s->schedule_file) }}" 
                                    target="_blank"
                                    class="text-blue-600 hover:underline">
                                    Ver horario
                                </a>
                            @else
                                <span class="text-gray-500">—</span>
                            @endif
                        </td>

                        <td class="px-3 py-2 text-center whitespace-nowrap">
                            @if($advisory)
                                {{ \Carbon\Carbon::parse($advisory->start_date)->format('d/m/Y') }}
                                <br>
                                {{ \Carbon\Carbon::parse($advisory->end_date)->format('d/m/Y') }}
                            @else
                                —
                            @endif
                        </td>

                        <td class="px-3 py-2 text-center whitespace-nowrap">
                            @if($advisory)
                                {{ ucfirst($advisory->day_of_week) }}
                                <br>
                                {{ \Carbon\Carbon::parse($advisory->start_time)->format('H:i') }}
                                –
                                {{ \Carbon\Carbon::parse($advisory->end_time)->format('H:i') }}
                            @else
                                —
                            @endif
                        </td>

                        <td class="px-3 py-2 whitespace-nowrap">
                            @if($advisory)
                                {{ $advisory->teacherSubject->teacher->name }}
                                {{ $advisory->teacherSubject->teacher->last_name_f }}
                            @else
                                —
                            @endif
                        </td>

                        <td class="px-3 py-2 whitespace-nowrap">
                            @if($advisory)
                                {{ $advisory->teacherSubject->subject->name }}
                            @else
                                —
                            @endif
                        </td>

                    </tr>

                @endforeach
            </tbody>

        </table>

    </div>

    <div class="mt-6 flex justify-center">
        {{ $students->links('vendor.pagination.tailwind') }}
    </div>

</div>

</main>

<x-basic-sciences-footer />

</body>
</html>


