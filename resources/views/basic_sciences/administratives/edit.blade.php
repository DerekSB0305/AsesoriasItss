<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Administrativo</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">

<div class="w-full max-w-3xl bg-white shadow-xl rounded-xl p-8">

    {{-- TÍTULO --}}
    <h1 class="text-3xl font-bold text-[#0B3D7E] mb-6 flex items-center">
        ✏️ Editar Administrativo
    </h1>

    {{-- BOTÓN VOLVER --}}
    <a href="{{ route('basic_sciences.administratives.index') }}"
       class="text-blue-600 hover:text-blue-800 mb-6 inline-block font-semibold">
        ← Volver a la lista
    </a>

    {{-- ERRORES --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-700 p-4 rounded-lg mb-4">
            <strong class="block mb-2">⚠️ Se encontraron errores:</strong>
            <ul class="list-disc ml-6">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORMULARIO --}}
    <form action="{{ route('basic_sciences.administratives.update', $administrative) }}"
          method="POST"
          class="grid grid-cols-1 md:grid-cols-2 gap-6">

        @csrf
        @method('PUT')

        {{-- USUARIO --}}
        <div class="col-span-2">
            <label class="font-semibold block mb-1">Usuario:</label>
            <input type="text"
                   name="administrative_user"
                   value="{{ $administrative->administrative_user }}"
                   class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-300"
                   required>
        </div>

        {{-- NOMBRE --}}
        <div>
            <label class="font-semibold block mb-1">Nombre:</label>
            <input type="text"
                   name="name"
                   value="{{ $administrative->name }}"
                   class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-300"
                   required>
        </div>

        {{-- APELLIDO PATERNO --}}
        <div>
            <label class="font-semibold block mb-1">Apellido Paterno:</label>
            <input type="text"
                   name="last_name_f"
                   value="{{ $administrative->last_name_f }}"
                   class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-300"
                   required>
        </div>

        {{-- APELLIDO MATERNO --}}
        <div>
            <label class="font-semibold block mb-1">Apellido Materno:</label>
            <input type="text"
                   name="last_name_m"
                   value="{{ $administrative->last_name_m }}"
                   class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-300"
                   required>
        </div>

        {{-- PUESTO --}}
        <div>
            <label class="font-semibold block mb-1">Puesto:</label>
            <input type="text"
                   name="position"
                   value="{{ $administrative->position }}"
                   class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-300"
                   required>
        </div>

        {{-- CARRERA --}}
        <div class="col-span-2">
            <label class="font-semibold block mb-1">Carrera (opcional):</label>
            <select name="career_id"
                    class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-300">
                <option value="">Sin carrera</option>

                @foreach($careers as $c)
                    <option value="{{ $c->career_id }}"
                        {{ $administrative->career_id == $c->career_id ? 'selected' : '' }}>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- BOTÓN GUARDAR --}}
        <div class="col-span-2 mt-4">
            <button type="submit"
                    class="w-full py-3 text-white font-bold rounded-lg shadow hover:opacity-90"
                    style="background-color:#28A745;">
                  Actualizar Administrativo
            </button>
        </div>

    </form>

</div>

</body>
</html>

