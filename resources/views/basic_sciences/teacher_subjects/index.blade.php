<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materias asignadas a maestros</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <x-basic-sciences-navbar />

<main class="flex-grow">

    <div class="w-full mx-auto bg-white shadow-xl rounded-xl 
                p-6 sm:p-8 mt-8 mb-10
                max-w-md sm:max-w-lg md:max-w-3xl lg:max-w-6xl">

        <h1 class="text-2xl sm:text-3xl font-bold mb-6 text-[#0B3D7E] flex items-center gap-2">
            📚 Asignaciones de Materias por Maestro
        </h1>

        <div class="flex flex-col sm:flex-row justify-between gap-3 mb-6">

            <a href="{{ route('basic_sciences.teacher_subjects.create') }}"
               class="px-4 py-2 rounded text-center text-white font-semibold shadow hover:opacity-90"
               style="background-color:#28A745;">
                ➕ Nueva asignación
            </a>

            <a href="{{ route('basic_sciences.index') }}"
               class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-center text-gray-800 font-semibold">
                ← Volver al inicio
            </a>
        </div>

        @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-700 p-3 rounded mb-6">
                ✔ {{ session('success') }}
            </div>
        @endif

        <form method="GET" class="mb-8 bg-gray-50 p-5 rounded-lg shadow-sm border">

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

                <div>
                    <label class="font-semibold text-gray-700">Buscar por maestro</label>
                    <input type="text" name="search_teacher"
                           value="{{ request('search_teacher') }}"
                           class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-300">
                </div>

                <div>
                    <label class="font-semibold text-gray-700">Buscar por materia</label>
                    <input type="text" name="search_subject"
                           value="{{ request('search_subject') }}"
                           class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-300">
                </div>

                <div>
                    <label class="font-semibold text-gray-700">Buscar por carrera</label>
                    <input type="text" name="search_career"
                           value="{{ request('search_career') }}"
                           class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-300">
                </div>

            </div>

            <button
                class="mt-4 px-4 py-2 bg-[#1ABC9C] text-white font-semibold rounded-lg hover:bg-blue-900 shadow">
                🔍 Buscar
            </button>

        </form>

        <div class="overflow-x-auto rounded-lg shadow-md border">
            <table class="w-full border-collapse">

                <thead class="bg-[#0B3D7E] text-white text-sm sm:text-base">
                    <tr>
                        <th class="px-3 sm:px-4 py-3">Maestro</th>
                        <th class="px-3 sm:px-4 py-3">Materia</th>
                        <th class="px-3 sm:px-4 py-3">Carrera</th>
                        <th class="px-3 sm:px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody class="text-gray-800 text-sm sm:text-base">

                    @foreach($teacherSubjects as $ts)
                    <tr class="border-b hover:bg-gray-100 transition">

                        <td class="px-3 sm:px-4 py-3">
                            {{ $ts->teacher->name }} {{ $ts->teacher->last_name_f }} {{ $ts->teacher->last_name_m }}
                        </td>

                        <td class="px-3 sm:px-4 py-3">
                            {{ $ts->subject->name }}
                        </td>

                        <td class="px-3 sm:px-4 py-3">
                            {{ $ts->career->name }}
                        </td>

                        <td class="px-3 sm:px-4 py-3">
                            <div class="flex justify-center gap-2 flex-wrap">

                                {{-- EDITAR --}}
                                <a href="{{ route('basic_sciences.teacher_subjects.edit', $ts->teacher_subject_id) }}"
                                   class="px-3 py-1 text-white text-sm font-semibold rounded shadow hover:opacity-90"
                                   style="background-color:#F39C12;">
                                    ✏ Editar
                                </a>

                                {{-- ELIMINAR --}}
                                <button onclick="openDeleteModal('{{ $ts->teacher_subject_id }}')"
                                        class="px-3 py-1 text-white text-sm font-semibold rounded shadow hover:opacity-90"
                                        style="background-color:#E74C3C;">
                                    🗑 Eliminar
                                </button>

                            </div>
                        </td>

                    </tr>
                    @endforeach

                </tbody>

            </table>
        </div>

        <div class="mt-6 flex justify-center">
            {{ $teacherSubjects->links('vendor.pagination.tailwind') }}
        </div>

    </div>

</main>

<x-basic-sciences-footer />

<div id="deleteModal"
     class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

    <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-xl">

        <h2 class="text-2xl font-bold text-[#0B3D7E] mb-4">
            ⚠ Confirmar Eliminación
        </h2>

        <p class="text-gray-700 mb-6">
            ¿Eliminar esta asignación permanentemente?
            <br>
            <strong class="text-red-600">Esta acción no se puede deshacer.</strong>
        </p>

        <div class="flex justify-end gap-3">

            <button onclick="closeDeleteModal()"
                    class="px-4 py-2 rounded text-white font-bold shadow"
                    style="background-color:#28A745;">
                Cancelar
            </button>

            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="px-4 py-2 rounded text-white font-bold shadow"
                        style="background-color:#E74C3C;">
                    Eliminar
                </button>
            </form>

        </div>

    </div>

</div>

<script>
    function openDeleteModal(id) {
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('deleteForm').action =
            "/basic_sciences/teacher_subjects/" + id;
    }
    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>

</body>
</html>



