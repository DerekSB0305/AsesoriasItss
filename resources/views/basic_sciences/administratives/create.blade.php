<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Administrativo</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 p-8">
<div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
    <h1 class="text-2xl font-bold mb-4">Nuevo Administrativo</h1>

    @if ($errors->any())
        <div class="mb-4 bg-red-100 text-red-700 p-3 rounded">
            <ul class="text-sm">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('basic_sciences.administratives.store') }}" method="POST" class="space-y-4">
        @csrf

        <div>
            <label class="block text-sm font-medium mb-1">Usuario Administrativo</label>
            <input type="text" name="administrative_user" value="{{ old('administrative_user') }}"
                   class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Nombre</label>
            <input type="text" name="name" value="{{ old('name') }}"
                   class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Apellido paterno</label>
            <input type="text" name="last_name_f" value="{{ old('last_name_f') }}"
                   class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Apellido materno</label>
            <input type="text" name="last_name_m" value="{{ old('last_name_m') }}"
                   class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Puesto</label>
            <input type="text" name="position" value="{{ old('position') }}"
                   class="w-full border rounded p-2">
        </div>

        <div>
            <label class="block text-sm font-medium mb-1">Carrera</label>
            <select name="career_id" class="w-full border rounded p-2">
                <option value="">Seleccione una carrera</option>
                @foreach($careers as $c)
                    <option value="{{ $c->career_id }}" {{ old('career_id') == $c->career_id ? 'selected' : '' }}>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Guardar
        </button>
    </form>
</div>
</body>
</html>
