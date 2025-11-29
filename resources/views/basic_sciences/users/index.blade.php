<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <div class="fixed top-0 w-full z-50">
        <x-basic-sciences-navbar />
    </div>

    <main class="flex-1 mt-28 mb-20 px-4">

        <div class="max-w-6xl mx-auto bg-white p-6 sm:p-8 rounded-xl shadow-lg">

            {{-- VOLVER --}}
            <div class="mb-6">
                <a href="{{ route('basic_sciences.index') }}" 
                   class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 
                          text-gray-800 font-semibold transition">
                    ← Volver al inicio
                </a>
            </div>

            {{-- TÍTULO --}}
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-6 text-center">
                👥 Gestión de Usuarios
            </h1>

            {{-- BUSCADOR --}}
            <form action="{{ route('basic_sciences.users.index') }}"
                  method="GET"
                  class="mb-8 bg-gray-50 p-6 rounded-lg shadow 
                         grid grid-cols-1 md:grid-cols-3 gap-6">

                <div>
                    <label class="block text-sm font-semibold mb-1">Buscar usuario:</label>
                    <input type="text"
                        name="search"
                        value="{{ request('search') }}"
                        class="w-full border rounded-lg px-3 py-2 
                               focus:ring-blue-500 focus:border-blue-500"
                        placeholder="Ingrese usuario">
                </div>

                <div>
                    <label class="block text-sm font-semibold mb-1">Filtrar por rol:</label>
                    <select name="role"
                        class="w-full border rounded-lg px-3 py-2 
                               focus:ring-blue-500 focus:border-blue-500">
                        <option value="">Todos</option>

                        @foreach($roles as $r)
                        <option value="{{ $r->id }}" {{ request('role') == $r->id ? 'selected' : '' }}>
                            {{ $r->role_type }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div class="flex items-end">
                    <button type="submit"
                        class="w-full px-6 py-2 rounded-lg text-white font-semibold 
                               transition flex items-center justify-center gap-2"
                        style="background-color:#1ABC9C;"
                        onmouseover="this.style.backgroundColor='#16A085'"
                        onmouseout="this.style.backgroundColor='#1ABC9C'">
                        🔍 Buscar
                    </button>
                </div>

            </form>

            {{-- MENSAJE ÉXITO --}}
            @if(session('success'))
                <div class="bg-green-100 border border-green-300 text-green-700 p-3 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif


            {{-- TABLA --}}
            <div class="overflow-x-auto rounded-lg border border-gray-200 shadow">

                <table class="min-w-full text-sm">

                    <thead class="bg-[#0B3D7E] text-white font-bold">
                        <tr>
                            <th class="p-3 whitespace-nowrap text-left">Usuario</th>
                            <th class="p-3 whitespace-nowrap text-left">Rol</th>
                            <th class="p-3 text-center whitespace-nowrap">Acciones</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white text-gray-700">

                        @foreach($users as $user)
                        <tr class="border-b hover:bg-gray-100 transition">

                            <td class="p-3">{{ $user->user }}</td>

                            <td class="p-3">{{ $user->role->role_type ?? 'Sin rol' }}</td>

                            <td class="p-3 flex flex-col sm:flex-row justify-center gap-2 text-center">

                                {{-- Editar --}}
                                <a href="{{ route('basic_sciences.users.edit', $user) }}"
                                   class="px-4 py-2 text-white rounded-lg font-semibold text-sm shadow"
                                   style="background-color:#F39C12;">
                                    ✏️ Editar contraseña
                                </a>

                                {{-- Eliminar --}}
                                <button type="button"
                                    onclick="openDeleteModal('{{ $user->user }}')"
                                    class="px-4 py-2 text-white rounded-lg font-semibold text-sm shadow"
                                    style="background-color:#E74C3C;">
                                    🗑️ Eliminar
                                </button>

                            </td>

                        </tr>
                        @endforeach

                    </tbody>

                </table>

            </div>

            {{-- PAGINACIÓN --}}
            <div class="mt-6 flex justify-center">
                {{ $users->links('vendor.pagination.tailwind') }}
            </div>

        </div>

    </main>

    <x-basic-sciences-footer />


    {{-- MODAL ELIMINAR --}}
    <div id="deleteModal"
        class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

        <div class="bg-white w-full max-w-md rounded-xl shadow-xl p-6">

            <h2 class="text-xl font-bold text-gray-900 mb-4">
                ❗ Confirmar eliminación
            </h2>

            <p class="text-gray-800 mb-6">
                ¿Seguro que deseas eliminar al usuario
                <span id="userToDelete" class="font-bold text-red-600"></span>?
                <br>Esta acción no se puede deshacer.
            </p>

            <div class="flex justify-end gap-4">

                <button onclick="closeDeleteModal()"
                    class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400 
                           text-gray-800 font-semibold">
                    Cancelar
                </button>

                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 rounded-lg text-white font-semibold shadow"
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
            document.getElementById('userToDelete').innerText = username;
            document.getElementById('deleteForm').action =
                "/basic_sciences/users/" + encodeURIComponent(username);
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
    </script>

</body>
</html>
