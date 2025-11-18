<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Administrativo</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 p-8">

<div class="max-w-xl mx-auto bg-white shadow-lg rounded-lg p-6">

    <h1 class="text-3xl font-bold text-[#0B3D7E] mb-6">
        ➕ Nuevo Administrativo
    </h1>

    {{-- Mensajes de error --}}
    @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-300 text-red-700 p-4 rounded-lg">
            <p class="font-semibold mb-2">Se encontraron los siguientes errores:</p>
            <ul class="list-disc ml-6 text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulario --}}
    <form action="{{ route('basic_sciences.administratives.store') }}"
          method="POST" class="space-y-4">

        @csrf

        <div>
            <label class="block font-medium mb-1">Usuario Administrativo</label>
            <input type="text" name="administrative_user" value="{{ old('administrative_user') }}"
                   class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200">
        </div>

        <div>
            <label class="block font-medium mb-1">Nombre</label>
            <input type="text" name="name" value="{{ old('name') }}"
                   class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200">
        </div>

        <div>
            <label class="block font-medium mb-1">Apellido Paterno</label>
            <input type="text" name="last_name_f" value="{{ old('last_name_f') }}"
                   class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200">
        </div>

        <div>
            <label class="block font-medium mb-1">Apellido Materno</label>
            <input type="text" name="last_name_m" value="{{ old('last_name_m') }}"
                   class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200">
        </div>

        <div>
            <label class="block font-medium mb-1">Puesto</label>
            <input type="text" name="position" value="{{ old('position') }}"
                   class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200">
        </div>

        <div>
            <label class="block font-medium mb-1">Carrera</label>
            <select name="career_id"
                    class="w-full border rounded-lg p-2 focus:ring focus:ring-blue-200">
                <option value="">Seleccione una carrera</option>
                @foreach($careers as $c)
                    <option value="{{ $c->career_id }}" {{ old('career_id') == $c->career_id ? 'selected' : '' }}>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <div class="flex items-center justify-between mt-6">

            {{-- Botón regresar --}}
            <a href="{{ route('basic_sciences.administratives.index') }}"
               class="px-4 py-2 rounded text-white font-semibold bg-gray-600 hover:bg-gray-700">
                ← Cancelar
            </a>

            {{-- Botón guardar --}}
            <button type="submit"
                    class="px-4 py-2 rounded text-white font-semibold hover:opacity-90"
                    style="background-color:#28A745;">
                Guardar
            </button>

        </div>

    </form>

</div>

</body>
</html>

