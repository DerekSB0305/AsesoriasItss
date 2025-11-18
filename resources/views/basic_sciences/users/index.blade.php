<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 p-8">

<div class="max-w-5xl mx-auto bg-white p-6 rounded-lg shadow">

    <a href="{{ route('basic_sciences.index') }}" class="text-blue-600 hover:underline">
        🔙 Volver al inicio
    </a>

    <h1 class="text-2xl font-bold mb-4">Usuarios Registrados</h1>

    {{-- BOTÓN CREAR --}}
    <a href="{{ route('basic_sciences.users.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 inline-block mb-4">
        + Crear nuevo usuario
    </a>

    {{-- BUSCADOR --}}
    <form action="{{ route('basic_sciences.users.index') }}" method="GET" class="mb-6 grid grid-cols-1 md:grid-cols-3 gap-4">

        {{-- Buscar por usuario --}}
        <div>
            <label class="block text-sm font-medium mb-1">Buscar usuario:</label>
            <input type="text" name="search" value="{{ request('search') }}"
                   placeholder="Ingrese nombre de usuario"
                   class="w-full border rounded px-3 py-2">
        </div>

        {{-- Filtrar por rol --}}
        <div>
            <label class="block text-sm font-medium mb-1">Filtrar por rol:</label>
            <select name="role" class="w-full border rounded px-3 py-2">
                <option value="">Todos</option>

                @foreach($roles as $r)
                    <option value="{{ $r->id }}" {{ request('role') == $r->id ? 'selected' : '' }}>
                        {{ $r->role_type }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Botón buscar --}}
        <div class="flex items-end">
            <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 w-full">
                Buscar
            </button>
        </div>
    </form>

    {{-- ALERTA --}}
    @if(session('success'))
        <div class="bg-green-100 border border-green-300 text-green-700 p-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLA --}}
    <table class="w-full mt-4 border rounded-lg overflow-hidden shadow-sm">
        <thead class="bg-gray-200">
            <tr>
                <th class="p-2">Usuario</th>
                <th class="p-2">Contraseña</th>
                <th class="p-2">Rol</th>
                <th class="p-2 text-center">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach($users as $user)
            <tr class="border-b hover:bg-gray-50">
                <td class="p-2">{{ $user->user }}</td>
                <td class="p-2">{{ $user->password }}</td>
                <td class="p-2">{{ $user->role->role_type ?? 'Sin rol' }}</td>

                <td class="p-2 text-center">
                    <a href="{{ route('basic_sciences.users.edit', $user) }}"
                       class="text-blue-600 hover:underline">Editar contraseña</a>
                    |
                    <form action="{{ route('basic_sciences.users.destroy', $user) }}"
                          method="POST" class="inline">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                onclick="return confirm('¿Eliminar este usuario?')"
                                class="text-red-600 hover:underline">
                            Eliminar
                        </button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>

</div>
</body>
</html>
