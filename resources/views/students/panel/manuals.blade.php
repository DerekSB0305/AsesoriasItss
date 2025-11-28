<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Manuales de Materias</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

<x-students-navbar/>

<div class="flex-grow p-6">

<div class="max-w-5xl mx-auto bg-white p-8 rounded-xl shadow-lg">

    {{-- REGRESAR --}}
    <a href="{{ route('students.panel.index') }}"
       class="text-indigo-600 hover:text-indigo-800 text-sm">
        ← Regresar al panel
    </a>

    <h1 class="text-3xl font-bold text-gray-800 mt-4 mb-6">
        📘 Manuales de Mis Materias
    </h1>

    {{-- 🔎 BUSCADOR Y FILTROS --}}
    <form method="GET" action="{{ route('students.panel.manuals') }}" class="mb-6 space-y-4">

        {{-- Buscador --}}
        <div class="flex flex-col md:flex-row items-center gap-3">
            <input 
                type="text"
                name="q"
                value="{{ request('q') }}"
                placeholder="Buscar por materia o título..."
                class="w-full px-4 py-2 border rounded-lg shadow-sm focus:ring focus:ring-indigo-200"
            >

            <button 
                type="submit"
                class="px-4 py-2 bg-indigo-600 text-white rounded-lg shadow hover:bg-indigo-700"
            >
                Buscar
            </button>
        </div>

        {{-- Filtros avanzados --}}
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            {{-- Filtro por Materia --}}
            <select 
                name="subject"
                class="px-3 py-2 border rounded-lg shadow-sm focus:ring focus:ring-indigo-200"
            >
                <option value="">— Todas las materias —</option>
                @foreach ($availableSubjects as $sub)
                    <option value="{{ optional($sub)->subject_id }}" 
                        {{ request('subject') == optional($sub)->subject_id ? 'selected' : '' }}>
                        {{ optional($sub)->name ?? 'Materia común' }}
                    </option>
                @endforeach
            </select>

            {{-- Filtro por Maestro --}}
            <select 
                name="teacher"
                class="px-3 py-2 border rounded-lg shadow-sm focus:ring focus:ring-indigo-200"
            >
                <option value="">— Todos los maestros —</option>
                @foreach ($availableTeachers as $teacher)
                    <option value="{{ optional($teacher)->teacher_user }}"
                        {{ request('teacher') == optional($teacher)->teacher_user ? 'selected' : '' }}>
                        {{ optional($teacher)->name }} {{ optional($teacher)->last_name_f }}
                    </option>
                @endforeach
            </select>

            {{-- Botón limpiar filtros --}}
            <a href="{{ route('students.panel.manuals') }}"
               class="px-3 py-2 bg-gray-200 text-gray-700 rounded-lg text-center hover:bg-gray-300">
                Limpiar filtros
            </a>

        </div>
    </form>

    {{-- SIN RESULTADOS --}}
    @if ($manuals->count() == 0)
        <p class="text-center text-gray-600 text-lg">
            No hay manuales disponibles con los filtros aplicados.
        </p>
    @else

        {{-- TABLA --}}
        <div class="overflow-x-auto mt-4">
            <table class="w-full text-left border-collapse shadow">

                <thead class="bg-gray-200 text-gray-700 uppercase text-sm">
                    <tr>
                        <th class="px-4 py-3">Materia</th>
                        <th class="px-4 py-3">Título del manual</th>
                        <th class="px-4 py-3">Maestro</th>
                        <th class="px-4 py-3 text-center">Archivo</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700">

                    @foreach ($manuals as $manual)
                        <tr class="border-b hover:bg-gray-50">

                            {{-- Materia --}}
                            <td class="px-4 py-3 font-semibold">
                                {{ optional($manual->teacherSubject->subject)->name ?? 'Materia común' }}
                            </td>

                            {{-- Título --}}
                            <td class="px-4 py-3">
                                {{ $manual->title }}
                            </td>

                            {{-- Maestro --}}
                            <td class="px-4 py-3">
                                {{ optional($manual->teacherSubject->teacher)->name }}
                                {{ optional($manual->teacherSubject->teacher)->last_name_f }}
                            </td>

                            {{-- Archivo --}}
                            <td class="px-4 py-3 text-center">
                                <a href="{{ asset('storage/' . $manual->file_path) }}"
                                   target="_blank"
                                   class="text-blue-600 hover:underline">
                                    Descargar
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
