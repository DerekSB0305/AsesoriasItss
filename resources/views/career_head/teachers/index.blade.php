<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maestros de mi Carrera</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- NAVBAR RESPONSIVA -->
    <x-career-head-navbar />

<main class="flex-grow">

<div class="w-[95%] max-w-7xl mx-auto bg-white shadow-lg rounded-xl p-6 sm:p-8 my-10">

    <!-- TÍTULO -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <h1 class="text-2xl sm:text-3xl font-bold text-[#0B3D7E]">
            👨‍🏫 Maestros de mi Carrera
        </h1>

        <a href="{{ route('career_head.index') }}"
           class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg font-semibold text-center">
            ← Volver al inicio
        </a>
    </div>

    <!-- BUSCADOR RESPONSIVO -->
    <form method="GET"
        class="bg-gray-50 p-4 rounded-lg shadow mb-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">

        <div>
            <label class="text-sm font-semibold">Nombre del maestro</label>
            <input type="text" name="nombre" value="{{ request('nombre') }}"
               class="w-full px-3 py-2 border rounded-lg focus:ring-[#0B3D7E]"
               placeholder="Ej. Juan Pérez">
        </div>

        <div>
            <label class="text-sm font-semibold">Tutor</label>
            <select name="tutor"
                class="w-full px-3 py-2 border rounded-lg focus:ring-[#0B3D7E]">
                <option value="">Todos</option>
                <option value="1" {{ request('tutor') == '1' ? 'selected' : '' }}>Sí</option>
                <option value="0" {{ request('tutor') == '0' ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <div>
            <label class="text-sm font-semibold">Horas CB</label>
            <select name="cb"
                class="w-full px-3 py-2 border rounded-lg focus:ring-[#0B3D7E]">
                <option value="">Todos</option>
                <option value="1" {{ request('cb') == '1' ? 'selected' : '' }}>Sí</option>
                <option value="0" {{ request('cb') == '0' ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <div class="flex items-end justify-start sm:justify-end lg:col-span-1">
            <button class="px-6 py-2 bg-[#1ABC9C] text-white rounded-lg shadow hover:bg-[#159a82] font-semibold w-full">
                🔍 Buscar
            </button>
        </div>

    </form>

    <!-- TABLA RESPONSIVA -->
    <div class="overflow-x-auto">

        <table class="w-full border-collapse shadow text-sm sm:text-base">

            <thead style="background-color:#0B3D7E;" class="text-white font-bold">
                <tr>
                    <th class="px-2 py-2">Usuario</th>
                    <th class="px-2 py-2">Nombre</th>
                    <th class="px-2 py-2">Grado</th>
                    <th class="px-2 py-2">Tutor</th>
                    <th class="px-2 py-2">Horas CB</th>
                    <th class="px-2 py-2 text-center">Horario</th>
                    <th class="px-2 py-2 text-center">Cantidad de Asesorías</th>
                    <th class="px-2 py-2 text-center">Manuales</th>
                </tr>
            </thead>

            <tbody class="text-gray-700">

                @foreach ($teachers as $t)

                <tr class="border-b hover:bg-gray-50 transition">

                    <td class="px-2 py-2">{{ $t->teacher_user }}</td>

                    <td class="px-2 py-2 font-semibold">
                        {{ $t->name }} {{ $t->last_name_f }} {{ $t->last_name_m }}
                    </td>

                    <td class="px-2 py-2">{{ $t->degree }}</td>

                    <td class="px-2 py-2">{{ $t->tutor ? 'Sí' : 'No' }}</td>

                    <td class="px-2 py-2">{{ $t->science_department ? 'Sí' : 'No' }}</td>

                    <td class="px-2 py-2 text-center">
                        @if($t->schedule)
                            <a href="{{ asset('storage/'.$t->schedule) }}" 
                               target="_blank"
                               class="text-blue-600 hover:text-blue-800">📄 Ver</a>
                        @else
                            <span class="text-gray-500">No disponible</span>
                        @endif
                    </td>

                    <td class="px-2 py-2 text-center font-semibold">
                        {{ $t->total_advisories }}
                    </td>

                    <td class="px-2 py-2 text-center font-semibold">
                        {{ $t->has_manuals ? '📘 Sí' : '—' }}
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

