<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Administrativos</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <x-basic-sciences-navbar />

    <main class="flex-grow">

        <div class="max-w-6xl mx-auto bg-white shadow-lg rounded-xl p-6 md:p-8 my-10">

            <h1 class="text-2xl md:text-3xl font-bold text-[#0B3D7E] mb-6 text-center">
                📋 Lista de Administrativos
            </h1>

            {{-- BOTONES SUPERIORES --}}
            <div class="flex flex-col md:flex-row justify-between gap-3 mb-6">

                <a href="{{ route('basic_sciences.administratives.create') }}"
                   class="w-full md:w-auto text-center px-4 py-2 rounded text-white font-semibold shadow"
                   style="background-color:#28A745;">
                    ➕ Crear Administrativo
                </a>

                <a href="{{ route('basic_sciences.index') }}"
                   class="w-full md:w-auto text-center px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold">
                    ← Regresar al inicio
                </a>
            </div>

            {{-- MENSAJE DE ÉXITO --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-300 text-green-700 p-3 rounded mb-4">
                    ✔ {{ session('success') }}
                </div>
            @endif

            {{-- TABLA RESPONSIVA --}}
            <div class="overflow-x-auto rounded-lg border shadow">
                <table class="w-full text-sm">

                    <thead style="background-color:#0B3D7E;" class="text-white font-bold text-left">
                        <tr>
                            <th class="px-4 py-3">Usuario</th>
                            <th class="px-4 py-3">Nombre</th>
                            <th class="px-4 py-3">Apellido P.</th>
                            <th class="px-4 py-3">Apellido M.</th>
                            <th class="px-4 py-3">Puesto</th>
                            <th class="px-4 py-3">Carrera</th>
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

                            <td class="px-4 py-3 text-center">
                                <div class="flex flex-col sm:flex-row justify-center gap-2">

                                    <a href="{{ route('basic_sciences.administratives.edit', $a) }}"
                                       class="px-3 py-1 rounded text-white font-semibold"
                                       style="background-color:#F39C12;">
                                        ✏ Editar
                                    </a>

                                    <button onclick="openDeleteModal('{{ $a->administrative_user }}')"
                                        class="px-3 py-1 rounded text-white font-semibold"
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
        </div>

    </main>

    <x-basic-sciences-footer />

    {{-- MODAL RESPONSIVO --}}
    <div id="deleteModal"
         class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50 px-4">

        <div class="bg-white w-full max-w-md p-6 rounded-lg shadow-xl">

            <h2 class="text-xl md:text-2xl font-bold text-[#0B3D7E] mb-4">
                ⚠ Confirmar Eliminación
            </h2>

            <p class="text-gray-700 mb-6 text-sm md:text-base">
                ¿Eliminar al administrativo  
                <strong id="adminName" class="text-red-600"></strong>?  
                <br><br>
                Esta acción no se puede deshacer.
            </p>

            <div class="flex flex-col sm:flex-row justify-end gap-3">

                <button onclick="closeDeleteModal()"
                        class="w-full sm:w-auto px-4 py-2 rounded text-white font-bold shadow"
                        style="background-color:#28A745;">
                    Cancelar
                </button>

                <form id="deleteForm" method="POST" class="inline w-full sm:w-auto">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="w-full sm:w-auto px-4 py-2 rounded text-white font-bold shadow"
                            style="background-color:#E74C3C;">
                         Eliminar
                    </button>
                </form>

            </div>

        </div>
    </div>

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





