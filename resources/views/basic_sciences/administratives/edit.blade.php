<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Administrativo</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

<x-basic-sciences-navbar />

<main class="flex-grow">

    {{-- CONTENEDOR RESPONSIVE --}}
    <div class="w-full mx-auto bg-white shadow-lg rounded-lg p-6 sm:p-8 mt-6 
                max-w-md sm:max-w-lg md:max-w-2xl lg:max-w-4xl">

        {{-- TÍTULO --}}
        <h1 class="text-2xl sm:text-3xl font-bold text-[#0B3D7E] mb-6 flex items-center gap-2">
            ✏️ Editar Administrativo
        </h1>

        {{-- ERRORES --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-300 text-red-700 p-4 rounded-lg text-sm">
                <p class="font-semibold mb-2">Se encontraron los siguientes errores:</p>
                <ul class="list-disc ml-6">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORMULARIO RESPONSIVE --}}
        <form action="{{ route('basic_sciences.administratives.update', $administrative) }}"
              method="POST"
              class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">

            @csrf
            @method('PUT')

            {{-- Usuario --}}
            <div>
                <label class="block font-semibold mb-1 text-[#0B3D7E]">Usuario Administrativo</label>
                <input type="text"
                       name="administrative_user"
                       value="{{ $administrative->administrative_user }}"
                       class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#0B3D7E]">
            </div>

            {{-- Nombre --}}
            <div>
                <label class="block font-semibold mb-1 text-[#0B3D7E]">Nombre</label>
                <input type="text"
                       name="name"
                       value="{{ $administrative->name }}"
                       class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#0B3D7E]">
            </div>

            {{-- Apellido Paterno --}}
            <div>
                <label class="block font-semibold mb-1 text-[#0B3D7E]">Apellido Paterno</label>
                <input type="text"
                       name="last_name_f"
                       value="{{ $administrative->last_name_f }}"
                       class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#0B3D7E]">
            </div>

            {{-- Apellido Materno --}}
            <div>
                <label class="block font-semibold mb-1 text-[#0B3D7E]">Apellido Materno</label>
                <input type="text"
                       name="last_name_m"
                       value="{{ $administrative->last_name_m }}"
                       class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#0B3D7E]">
            </div>

            {{-- Puesto --}}
            <div>
                <label class="block font-semibold mb-1 text-[#0B3D7E]">Puesto</label>
                <input type="text"
                       name="position"
                       value="{{ $administrative->position }}"
                       class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#0B3D7E]">
            </div>

            {{-- Carrera --}}
            <div>
                <label class="block font-semibold mb-1 text-[#0B3D7E]">Carrera (opcional)</label>
                <select name="career_id"
                        class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-[#0B3D7E]">
                    <option value="">Sin carrera</option>
                    @foreach($careers as $c)
                        <option value="{{ $c->career_id }}"
                            {{ $administrative->career_id == $c->career_id ? 'selected' : '' }}>
                            {{ $c->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- BOTONES RESPONSIVE --}}
            <div class="col-span-1 md:col-span-2 flex flex-col sm:flex-row justify-between mt-6 gap-3">

                <a href="{{ route('basic_sciences.administratives.index') }}"
                   class="px-4 py-2 text-center rounded text-white font-semibold bg-gray-600 hover:bg-gray-700">
                    ← Cancelar
                </a>

                <button type="submit"
                        class="px-6 py-2 rounded text-white font-semibold shadow hover:opacity-90"
                        style="background-color:#28A745;">
                    Actualizar Administrativo
                </button>

            </div>

        </form>

    </div>

</main>

<x-basic-sciences-footer/>

</body>
</html>




