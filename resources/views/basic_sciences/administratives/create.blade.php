<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Administrativo</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- NAVBAR --}}
    <x-basic-sciences-navbar />

    {{-- CONTENEDOR --}}
    <div class="w-full max-w-4xl mx-auto bg-white shadow-lg rounded-lg p-8 mt-8">

        {{-- TÍTULO --}}
        <h1 class="text-3xl font-bold text-[#0B3D7E] mb-6 flex items-center gap-2">
            ➕ Nuevo Administrativo
        </h1>

        {{-- ERRORES DETALLADOS --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-300 text-red-700 p-4 rounded-lg">
                <p class="font-semibold mb-2">Se encontraron los siguientes errores:</p>
                <ul class="list-disc ml-6 text-sm">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORMULARIO EN 2 COLUMNAS --}}
        <form action="{{ route('basic_sciences.administratives.store') }}"
              method="POST"
              class="grid grid-cols-1 md:grid-cols-2 gap-6">

            @csrf

            {{-- USUARIO --}}
            <div>
                <label class="block font-semibold mb-1 text-[#0B3D7E]">Usuario Administrativo</label>
                <input type="text" name="administrative_user" 
                       value="{{ old('administrative_user') }}"
                       class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#0B3D7E]">
            </div>

            {{-- NOMBRE --}}
            <div>
                <label class="block font-semibold mb-1 text-[#0B3D7E]">Nombre</label>
                <input type="text" name="name" 
                       value="{{ old('name') }}"
                       class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#0B3D7E]">
            </div>

            {{-- APELLIDO PATERNO --}}
            <div>
                <label class="block font-semibold mb-1 text-[#0B3D7E]">Apellido Paterno</label>
                <input type="text" name="last_name_f" 
                       value="{{ old('last_name_f') }}"
                       class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#0B3D7E]">
            </div>

            {{-- APELLIDO MATERNO --}}
            <div>
                <label class="block font-semibold mb-1 text-[#0B3D7E]">Apellido Materno</label>
                <input type="text" name="last_name_m" 
                       value="{{ old('last_name_m') }}"
                       class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#0B3D7E]">
            </div>

            {{-- PUESTO --}}
            <div>
                <label class="block font-semibold mb-1 text-[#0B3D7E]">Puesto</label>
                <input type="text" name="position" 
                       value="{{ old('position') }}"
                       class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#0B3D7E]">
            </div>

            {{-- CARRERA --}}
            <div>
                <label class="block font-semibold mb-1 text-[#0B3D7E]">Carrera</label>
                <select name="career_id"
                        class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#0B3D7E]">
                    <option value="">Seleccione una carrera</option>
                    @foreach($careers as $c)
                        <option value="{{ $c->career_id }}" 
                            {{ old('career_id') == $c->career_id ? 'selected' : '' }}>
                            {{ $c->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- BOTONES --}}
            <div class="col-span-1 md:col-span-2 flex justify-between mt-6">

                <a href="{{ route('basic_sciences.administratives.index') }}"
                   class="px-4 py-2 rounded text-white font-semibold bg-gray-600 hover:bg-gray-700">
                    ← Cancelar
                </a>

                <button type="submit"
                        class="px-6 py-2 rounded text-white font-semibold shadow hover:opacity-90"
                        style="background-color:#28A745;">
                    Guardar
                </button>

            </div>

        </form>

    </div>

    {{-- FOOTER --}}
    <x-basic-sciences-footer />

</body>
</html>


