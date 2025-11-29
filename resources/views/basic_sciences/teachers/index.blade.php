<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Maestros</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

<x-basic-sciences-navbar />

<main class="flex-grow">

<div class="w-[95%] max-w-7xl mx-auto bg-white shadow-lg rounded-xl p-6 sm:p-8 my-10">

    <h1 class="text-2xl sm:text-3xl font-bold text-[#0B3D7E] mb-6">
        👨‍🏫 Lista de Maestros
    </h1>
    
    <form method="GET"
      class="bg-gray-50 p-4 rounded-lg shadow mb-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div>
            <label class="text-sm font-semibold">Nombre del maestro</label>
            <input type="text" name="search" value="{{ request('search') }}"
               class="w-full px-3 py-2 border rounded-lg focus:ring-[#0B3D7E]"
               placeholder="Ej. Juan Pérez">
        </div>

        <div>
            <label class="text-sm font-semibold">¿Es tutor?</label>
            <select name="tutor"
                class="w-full px-3 py-2 border rounded-lg focus:ring-[#0B3D7E]">
            <option value="">Todos</option>
            <option value="1" {{ request('tutor') == '1' ? 'selected' : '' }}>Sí</option>
            <option value="0" {{ request('tutor') == '0' ? 'selected' : '' }}>No</option>
            </select>
        </div>

         <div>
            <label class="text-sm font-semibold">Ciencias Básicas</label>
            <select name="science"
                class="w-full px-3 py-2 border rounded-lg focus:ring-[#0B3D7E]">
                <option value="">Todos</option>
                <option value="1" {{ request('science') == '1' ? 'selected' : '' }}>Sí</option>
                <option value="0" {{ request('science') == '0' ? 'selected' : '' }}>No</option>
            </select>
        </div>

        <div>
            <label class="text-sm font-semibold">Grado de estudio</label>
            <input type="text" name="degree" value="{{ request('degree') }}"
               class="w-full px-3 py-2 border rounded-lg focus:ring-[#0B3D7E]"
               placeholder="Ej. Maestría, Doctorado">
         </div>

        <div class="sm:col-span-2 lg:col-span-4 flex justify-end">
            <button class="px-6 py-2 bg-[#1ABC9C] text-white rounded-lg shadow hover:bg-[#159a82] font-semibold">
                🔍 Buscar
            </button>
        </div>
    </form>


    <div class="flex flex-col sm:flex-row justify-between gap-3 mb-4">

        <a href="{{ route('basic_sciences.teachers.create') }}"
           class="px-4 py-2 rounded text-white font-semibold shadow text-center"
           style="background-color:#28A745;">
            ➕ Agregar Maestro
        </a>

        <a href="{{ route('basic_sciences.index') }}"
           class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold text-center">
            ← Volver al inicio
        </a>
    </div>

    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 p-3 rounded mb-4">
            ✔ {{ session('success') }}
        </div>
    @endif

    <div class="overflow-x-auto">

        <table class="w-full border-collapse shadow text-sm sm:text-base">

            <thead style="background-color:#0B3D7E;" class="text-white font-bold">
                <tr>
                    <th class="px-2 py-2 text-left">Usuario</th>
                    <th class="px-2 py-2 text-left">Nombre</th>
                    <th class="px-2 py-2 text-left">Apellido P.</th>
                    <th class="px-2 py-2 text-left">Apellido M.</th>
                    <th class="px-2 py-2 text-left">Grado</th>
                    <th class="px-2 py-2 text-left">Tutor</th>
                    <th class="px-2 py-2 text-left">Ciencias Básicas</th>
                    <th class="px-2 py-2 text-left">Carrera</th>
                    <th class="px-2 py-2 text-center">Horario</th>
                    <th class="px-2 py-2 text-center">Asesoría</th>
                    <th class="px-2 py-2 text-center">Acciones</th>
                </tr>
            </thead>

            <tbody class="text-gray-700">

                @foreach ($teachers as $t)
                    <tr class="border-b hover:bg-gray-50 transition">

                        <td class="px-2 py-2">{{ $t->teacher_user }}</td>
                        <td class="px-2 py-2">{{ $t->name }}</td>
                        <td class="px-2 py-2">{{ $t->last_name_f }}</td>
                        <td class="px-2 py-2">{{ $t->last_name_m }}</td>
                        <td class="px-2 py-2">{{ $t->degree }}</td>
                        <td class="px-2 py-2">{{ $t->tutor ? 'Sí' : 'No' }}</td>
                        <td class="px-2 py-2">{{ $t->science_department ? 'Sí' : 'No' }}</td>
                        <td class="px-2 py-2">{{ $t->career->name ?? 'Sin carrera' }}</td>

                        <td class="px-2 py-2 text-center">
                            @if($t->schedule)
                                <a href="{{ asset('storage/'.$t->schedule) }}"
                                   class="text-blue-600 hover:text-blue-800"
                                   target="_blank">📄 Ver</a>
                            @else
                                <span class="text-gray-500">No disponible</span>
                            @endif
                        </td>

                        <td class="px-2 py-2 text-center">
                            @if($t->advisory)
                                <a href="{{ route('basic_sciences.advisories.show', $t->advisory) }}"
                                   class="text-blue-600 hover:underline">
                                    Ver
                                </a>
                            @else
                                <span class="text-gray-500">Sin asignar</span>
                            @endif
                        </td>

                        <td class="px-2 py-2 text-center">
                            <div class="flex flex-col sm:flex-row justify-center gap-2">

                                <a href="{{ route('basic_sciences.teachers.edit', $t) }}"
                                   class="px-3 py-1 rounded text-white font-semibold text-center"
                                   style="background-color:#F39C12;">
                                    ✏ Editar
                                </a>

                                <button onclick="openDeleteModal('{{ $t->teacher_user }}')"
                                        class="px-3 py-1 rounded text-white font-semibold text-center"
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
    {{ $teachers->links('vendor.pagination.tailwind') }}
</div>

</div>


<div id="deleteModal"
     class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

    <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-xl">

        <h2 class="text-2xl font-bold text-[#0B3D7E] mb-4">⚠ Confirmar Eliminación</h2>

        <p class="text-gray-700 mb-6">
            ¿Deseas eliminar al maestro  
            <strong id="teacherName" class="text-red-600"></strong>?
            <br><br>
            Esta acción no se puede deshacer.
        </p>

        <div class="flex justify-end gap-3">

            <button onclick="closeDeleteModal()"
                    class="px-4 py-2 rounded text-white font-bold shadow"
                    style="background-color:#28A745;">
                Cancelar
            </button>

            <form id="deleteForm" method="POST" class="inline">
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
</main>

<x-basic-sciences-footer />

<script>
    function openDeleteModal(username) {
        document.getElementById('deleteModal').classList.remove('hidden');
        document.getElementById('teacherName').innerText = username;
        document.getElementById('deleteForm').action =
            "/basic_sciences/teachers/" + encodeURIComponent(username);
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>

</body>
</html>
