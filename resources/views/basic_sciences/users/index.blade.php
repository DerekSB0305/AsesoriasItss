<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestión de Usuarios</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- NAVBAR --}}
    <x-basic-sciences-navbar />

    <main class="flex-grow">

        <div class="max-w-6xl mx-auto bg-white p-8 mt-10 mb-10 rounded-xl shadow-lg">

            {{-- BOTÓN VOLVER --}}
            <div class="mb-6">
                <a href="{{ route('basic_sciences.index') }}" 
                   class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold transition">
                    ← Volver al inicio
                </a>
            </div>

            <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">
                👥 Gestión de Usuarios
            </h1>

            {{-- BUSCADOR --}}
            <form action="{{ route('basic_sciences.users.index') }}"
                method="GET"
                class="mb-8 bg-gray-50 p-6 rounded-lg shadow flex flex-col md:flex-row gap-6">

                <div class="flex-1">
                    <label class="block text-sm font-semibold mb-1">Buscar usuario:</label>
                    <input type="text" name="search" value="{{ request('search') }}"
                           class="w-full border rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500"
                           placeholder="Ingrese usuario">
                </div>

                <div class="flex-1">
                    <label class="block text-sm font-semibold mb-1">Filtrar por rol:</label>
                    <select name="role"
                            class="w-full border rounded-lg px-3 py-2 focus:ring-blue-500 focus:border-blue-500">
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
                        class="px-6 py-2 rounded-lg text-white font-semibold transition flex items-center gap-2"
                        style="background-color:#1ABC9C;"
                        onmouseover="this.style.backgroundColor='#16A085'"
                        onmouseout="this.style.backgroundColor='#1ABC9C'">
                        🔍 Buscar
                    </button>
                </div>
            </form>

            {{-- ALERTA --}}
            @if(session('success'))
            <div class="bg-green-100 border border-green-300 text-green-700 p-3 rounded mb-4">
                {{ session('success') }}
            </div>
            @endif

            <div class="overflow-x-auto">
                <table class="w-full rounded-lg shadow-sm overflow-hidden">

                    <thead class="bg-[#0B3D7E] text-white font-bold">
                        <tr>
                            <th class="p-3">Usuario</th>
                            <th class="p-3">Contraseña</th>
                            <th class="p-3">Rol</th>
                            <th class="p-3 text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody class="bg-white">
                        @foreach($users as $user)
                        <tr class="border-b hover:bg-gray-100 transition">

                            <td class="p-3">{{ $user->user }}</td>
                            <td class="p-3">{{ $user->password }}</td>
                            <td class="p-3">{{ $user->role->role_type ?? 'Sin rol' }}</td>

                            <td class="p-3 text-center flex justify-center gap-2">

                                {{-- EDITAR --}}
                                <a href="{{ route('basic_sciences.users.edit', $user) }}"
                                   class="px-4 py-2 rounded-lg text-white font-semibold"
                                   style="background-color:#F39C12;">
                                    ✏️ Editar
                                </a>

                                {{-- ELIMINAR (abre modal) --}}
                                <button type="button"
                                    onclick="openDeleteModal('{{ $user->user }}')"
                                    class="px-4 py-2 rounded-lg text-white font-semibold"
                                    style="background-color:#E74C3C;">
                                    🗑️ Eliminar
                                </button>

                            </td>
                        </tr>
                        @endforeach
                    </tbody>

                </table>
            </div>

        </div>

    </main>


    <x-basic-sciences-footer />

{{-- Confirmar eliminación --}}
    <div id="deleteModal"
        class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

        <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md">

            <h2 class="text-xl font-bold text-gray-900 mb-4">
                ❗ Confirmar eliminación
            </h2>

            <p class="text-gray-700 mb-6">
                ¿Seguro que deseas eliminar al usuario
                <span class="font-bold text-red-600" id="userToDelete"></span>?
                <br>
                Esta acción no se puede deshacer.
            </p>

            <div class="flex justify-end gap-4">

                <button onclick="closeDeleteModal()"
                    class="px-4 py-2 bg-gray-300 rounded-lg hover:bg-gray-400 text-gray-800 font-semibold">
                    Cancelar
                </button>

                <form id="deleteForm" method="POST">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                        class="px-4 py-2 rounded-lg text-white font-semibold"
                        style="background-color:#E74C3C;">
                        Eliminar
                    </button>
                </form>

            </div>

        </div>
    </div>

    {{-- SCRIPT DEL MODAL --}}
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
