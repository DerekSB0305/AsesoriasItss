<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Usuario</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Crear Usuario</h1>

        <form method="POST" action="{{ route('basic_sciences.users.store') }}" class="space-y-4">
            @csrf

            <div>
                <label class="block mb-1 font-medium">Usuario (matrícula o nombre)</label>
                <input type="text" name="user" class="w-full border rounded p-2" required>
            </div>

            <div>
                <label class="block mb-1 font-medium">Rol</label>
                <select name="role_id" class="w-full border rounded p-2" required>
                    <option value="">Seleccione un rol</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->role_type }}</option>
                    @endforeach
                </select>
            </div>

            <button type="submit" class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
                Guardar
            </button>
        </form>
    </div>
</body>
</html>
