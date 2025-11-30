<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Manuales de Mis Materias</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- NAVBAR --}}
    <div class="fixed top-0 left-0 w-full z-50 shadow">
        <x-teachers-navbar />
    </div>

<main class="flex-1 mt-28 mb-20 px-4">

<div class="max-w-6xl mx-auto bg-white shadow-xl rounded-xl p-6 sm:p-8">

    {{-- HEADER --}}
    <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">

        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0B3D7E]">
            📘 Manuales de Mis Materias
        </h1>

        <a href="{{ route('teachers.index') }}"
           class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg font-semibold">
            ← Volver al panel
        </a>
    </div>

    {{-- BOTÓN SUBIR MANUAL --}}
    <div class="flex justify-end mb-6">
        <a href="{{ route('teachers.manuals.select_subject') }}"
           class="px-4 py-2 bg-[#28A745] hover:bg-[#218838] text-white rounded-lg shadow font-semibold">
            ➕ Subir manual
        </a>
    </div>

    {{-- SIN MANUALES --}}
    @if ($manuals->count() == 0)
        <p class="text-center text-gray-600 text-lg py-10">
            No tienes manuales subidos aún.
        </p>
    @else

    {{-- TABLA --}}
    <div class="overflow-x-auto rounded-xl border border-gray-200 shadow">

        <table class="min-w-full text-xs sm:text-sm">

            <thead class="text-white uppercase font-semibold" style="background-color:#0B3D7E;">
                <tr>
                    <th class="px-4 py-3 whitespace-nowrap text-left">Materia</th>
                    <th class="px-4 py-3 whitespace-nowrap text-left">Manual</th>
                    <th class="px-4 py-3 whitespace-nowrap text-left">Archivo</th>
                    <th class="px-4 py-3 whitespace-nowrap text-center">Acciones</th>
                </tr>
            </thead>

            <tbody class="text-gray-800">

                @foreach ($manuals as $manual)
                <tr class="border-b hover:bg-gray-100 transition">

                    {{-- Materia --}}
                    <td class="px-4 py-3 font-semibold whitespace-nowrap">
                        {{ $manual->teacherSubject->subject->name }}
                    </td>

                    {{-- Título --}}
                    <td class="px-4 py-3 whitespace-nowrap">
                        {{ $manual->title }}
                    </td>

                    {{-- Archivo --}}
                    <td class="px-4 py-3 whitespace-nowrap">
                        <a href="{{ asset('storage/' . $manual->file_path) }}"
                           target="_blank"
                           class="text-blue-600 hover:underline font-semibold">
                            📄 Ver archivo
                        </a>
                    </td>

                    {{-- Acciones --}}
                    <td class="px-4 py-3 text-center whitespace-nowrap">

                        <form action="{{ route('teachers.manuals.destroy', $manual->id) }}"
                              method="POST"
                              onsubmit="return confirm('¿Eliminar este manual?')">

                            @csrf
                            @method('DELETE')

                            <button
                                class="px-3 py-1 bg-red-600 text-white rounded-lg shadow hover:bg-red-700 text-xs sm:text-sm">
                                🗑 Eliminar
                            </button>

                        </form>

                    </td>

                </tr>
                @endforeach

            </tbody>

        </table>

    </div>

    {{-- PAGINACIÓN --}}
    <div class="mt-6 flex justify-center">
        {{ $manuals->links('vendor.pagination.tailwind') }}
    </div>

    @endif

</div>

</main>

<x-basic-sciences-footer />

</body>
</html>
