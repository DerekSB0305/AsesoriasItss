<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Materias</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- NAVBAR --}}
    <div class="fixed top-0 left-0 w-full z-50 shadow">
        <x-basic-sciences-navbar />
    </div>

    <main class="flex-1 mt-28 mb-20 px-4">

        <div class="max-w-7xl mx-auto bg-white shadow-xl rounded-xl p-6 sm:p-8">

            {{-- HEADER --}}
            <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">

                <a href="{{ route('basic_sciences.index') }}"
                    class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg font-semibold text-center">
                    ← Volver al inicio
                </a>

                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0B3D7E]">
                    📘 Materias
                </h1>

                <a href="{{ route('basic_sciences.subjects.create') }}"
                    class="px-4 py-2 bg-[#28A745] hover:bg-[#218838] text-white rounded-lg shadow font-semibold">
                    ➕ Nueva Materia
                </a>

            </div>

            {{-- FILTROS --}}
            <form method="GET" class="bg-gray-50 p-4 rounded-lg shadow grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">

                {{-- Buscar --}}
                <div>
                    <label class="text-sm font-semibold">Buscar materia</label>
                    <input 
                        type="text"
                        name="search"
                        value="{{ $search }}"
                        class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-[#0B3D7E]"
                        placeholder="Ej. Álgebra, Química">
                </div>

                {{-- Carrera --}}
                <div>
                    <label class="text-sm font-semibold">Carrera</label>
                    <select name="career"
                        class="w-full mt-1 px-4 py-2 border rounded-lg focus:ring-[#0B3D7E]">
                        <option value="">Todas</option>

                        <option value="common" {{ $career === 'common' ? 'selected' : '' }}>
                            Materia común
                        </option>

                        @foreach($careers as $c)
                            <option value="{{ $c->career_id }}" 
                                {{ $career == $c->career_id ? 'selected' : '' }}>
                                {{ $c->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- Botón buscar --}}
                <div class="flex items-end">
                    <button 
                        class="px-4 py-2 w-full bg-[#1ABC9C] hover:bg-[#159a82] 
                               text-white rounded-lg shadow font-semibold">
                        🔍 Buscar
                    </button>
                </div>

            </form>

            {{-- TABLA --}}
            <div class="overflow-x-auto rounded-xl border border-gray-200 shadow">

                <table class="min-w-full text-xs sm:text-sm">

                    <thead class="text-white uppercase font-semibold" style="background-color:#0B3D7E;">
                        <tr>
                            <th class="px-4 py-3 whitespace-nowrap">Materia</th>
                            <th class="px-4 py-3 whitespace-nowrap">Tipo</th>
                            <th class="px-4 py-3 whitespace-nowrap">Carrera</th>
                            <th class="px-4 py-3 whitespace-nowrap">Periodo</th>
                            <th class="px-4 py-3 text-center whitespace-nowrap">Acciones</th>
                        </tr>
                    </thead>

                    <tbody class="text-gray-800">

                        @foreach ($subjects as $s)
                        <tr class="border-b hover:bg-gray-100 transition">

                            <td class="px-4 py-3 font-semibold">{{ $s->name }}</td>

                            <td class="px-4 py-3">{{ $s->type ?? '---' }}</td>

                            <td class="px-4 py-3">
                                {{ $s->career->name ?? 'Materia común' }}
                            </td>

                            <td class="px-4 py-3">{{ $s->period ?? '---' }}</td>

                            {{-- Acciones --}}
                            <td class="px-4 py-3 flex flex-col sm:flex-row gap-2 justify-center">

                                {{-- Editar --}}
                                <a href="{{ route('basic_sciences.subjects.edit', $s->subject_id) }}"
                                    class="px-3 py-1 rounded-lg text-white shadow font-semibold"
                                    style="background-color:#F39C12;">
                                    ✏ Editar
                                </a>

                                {{-- Eliminar - abre modal --}}
                                <button 
                                    onclick="openDeleteModal('{{ $s->name }}', '{{ $s->subject_id }}')"
                                    class="px-3 py-1 rounded-lg text-white shadow font-semibold"
                                    style="background-color:#E74C3C;">
                                    🗑 Eliminar
                                </button>

                            </td>

                        </tr>
                        @endforeach

                    </tbody>
                </table>

            </div>

            {{-- PAGINACIÓN --}}
            <div class="mt-6 flex justify-center">
                {{ $subjects->links('vendor.pagination.tailwind') }}
            </div>

        </div>

    </main>

    <x-basic-sciences-footer />



    {{-- MODAL ELIMINAR --}}
    <div id="deleteModal"
         class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 px-4">

        <div class="bg-white w-full max-w-md p-6 rounded-xl shadow-2xl">

            <h2 class="text-xl font-bold text-red-600 mb-4">
                ⚠ Confirmar eliminación
            </h2>

            <p class="text-gray-700">
                ¿Eliminar la materia <strong id="subjectName"></strong>?  
                <br>Esta acción es irreversible.
            </p>

            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')

                <div class="flex justify-end gap-3 mt-6">

                    <button type="button"
                        onclick="closeDeleteModal()"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                        Cancelar
                    </button>

                    <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Eliminar
                    </button>

                </div>
            </form>

        </div>

    </div>

    <script>
        function openDeleteModal(name, id) {
            document.getElementById('subjectName').innerText = name;
            document.getElementById('deleteForm').action =
                "/basic_sciences/subjects/" + encodeURIComponent(id);
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
    </script>

</body>
</html>
