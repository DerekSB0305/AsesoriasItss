<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrativos</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 p-8">

    <div class="max-w-6xl mx-auto bg-white shadow-lg rounded-xl p-8">

        {{-- TÍTULO --}}
        <h1 class="text-3xl font-bold text-[#0B3D7E] mb-6">
            📋 Lista de Administrativos
        </h1>

        <div class="flex justify-between mb-4">
            {{-- BOTÓN CREAR --}}
            <a href="{{ route('basic_sciences.administratives.create') }}"
               class="px-4 py-2 rounded text-white font-semibold shadow"
               style="background-color:#28A745;">
                ➕ Crear Administrativo
            </a>

            {{-- BOTÓN VOLVER --}}
            <a href="{{ route('basic_sciences.index') }}"
               class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold">
                ← Regresar al inicio
            </a>
        </div>

        {{-- MENSAJE DE ÉXITO --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-300 text-green-700 p-3 rounded mb-4">
                ✔ {{ session('success') }}
            </div>
        @endif

        {{-- TABLA --}}
        <div class="overflow-x-auto">
            <table class="w-full border-collapse shadow">

                <thead style="background-color:#0B3D7E;" class="text-white font-bold">
                    <tr>
                        <th class="px-4 py-3 text-left">Usuario</th>
                        <th class="px-4 py-3 text-left">Nombre</th>
                        <th class="px-4 py-3 text-left">Apellido Paterno</th>
                        <th class="px-4 py-3 text-left">Apellido Materno</th>
                        <th class="px-4 py-3 text-left">Puesto</th>
                        <th class="px-4 py-3 text-left">Carrera</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700">

                    @foreach ($administratives as $a)
                    <tr class="border-b hover:bg-gray-50 transition">

                        <td class="px-4 py-3">{{ $a->administrative_user }}</td>
                        <td class="px-4 py-3">{{ $a->name }}</td>
                        <td class="px-4 py-3">{{ $a->last_name_f }}</td>
                        <td class="px-4 py-3">{{ $a->last_name_m }}</td>
                        <td class="px-4 py-3">{{ $a->position }}</td>
                        <td class="px-4 py-3">{{ $a->career->name ?? 'N/A' }}</td>

                        <td class="px-4 py-3 text-center flex gap-2 justify-center">

                            {{-- EDITAR --}}
                            <a href="{{ route('basic_sciences.administratives.edit', $a) }}"
                               class="px-3 py-1 rounded text-white font-semibold"
                               style="background-color:#F39C12;">
                               ✏  Editar
                            </a>

                            {{-- ELIMINAR --}}
                            <button onclick="openDeleteModal('{{ $a->administrative_user }}')"
                                    class="px-3 py-1 rounded text-white font-semibold"
                                    style="background-color:#E74C3C;">
                                 🗑 Eliminar
                            </button>

                        </td>

                    </tr>
                    @endforeach

                </tbody>

            </table>
        </div>
    </div>

    {{-- ===== MODAL DE CONFIRMACIÓN ===== --}}
    <div id="deleteModal"
         class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

        <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-xl">

            <h2 class="text-2xl font-bold text-[#0B3D7E] mb-4">
                ⚠ Confirmar Eliminación
            </h2>

            <p class="text-gray-700 mb-6">
                ¿Eliminar al administrativo  
                <strong id="adminName" class="text-red-600"></strong>?  
                <br><br>
                Esta acción no se puede deshacer.
            </p>

            <div class="flex justify-end gap-3">

                {{-- CANCELAR --}}
                <button onclick="closeDeleteModal()"
                        class="px-4 py-2 rounded text-white font-bold shadow"
                        style="background-color:#28A745;">
                    Cancelar
                </button>

                {{-- FORM ELIMINAR --}}
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

    {{-- SCRIPT --}}
    <script>
        function openDeleteModal(username) {
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('adminName').innerText = username;

            document.getElementById('deleteForm').action =
                "/basic_sciences/administratives/" + encodeURIComponent(username);
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
    </script>

</body>
</html>




