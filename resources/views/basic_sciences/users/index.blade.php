<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Gestión de Usuarios</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-5xl mx-auto bg-white p-6 rounded-lg shadow">
        <h1 class="text-2xl font-bold mb-4">Usuarios Registrados</h1>

        <a href="{{ route('basic_sciences.users.create') }}" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Crear nuevo usuario
        </a>

        @if(session('success'))
            <div class="mt-3 bg-green-100 border border-green-300 text-green-700 p-3 rounded">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full mt-4 border">
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
                <tr class="border-b">
                    <td class="p-2">{{ $user->user }}</td>
                    <td class="p-2">{{ $user->password }}</td>
                    <td class="p-2">{{ $user->role->role_type ?? 'Sin rol' }}</td>
                    <td class="p-2 text-center">
                        <a href="{{ route('basic_sciences.users.edit', $user) }}" class="text-blue-600 hover:underline">Editar contraseña</a> |
                        <form action="{{ route('basic_sciences.users.destroy', $user) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Eliminar este usuario?')" class="text-red-600 hover:underline">Eliminar</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
