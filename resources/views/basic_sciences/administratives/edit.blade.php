<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Administrativo</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <x-basic-sciences-navbar />

<main class="flex-grow">

    <div class="w-full max-w-3xl mx-auto bg-white shadow-xl rounded-xl p-8 mt-8 mb-8">

        <h1 class="text-3xl font-bold text-[#0B3D7E] mb-6 flex items-center gap-2">
            ✏️ Editar Administrativo
        </h1>

        <a href="{{ route('basic_sciences.administratives.index') }}"
           class="inline-block mb-6 text-gray-700 font-semibold px-4 py-2 rounded-lg 
                  bg-gray-200 hover:bg-gray-300 transition">
            ← Volver a la lista
        </a>

        @if ($errors->any())
            <div class="bg-red-100 border border-red-300 text-red-700 p-4 rounded-lg mb-4">
                <strong class="block mb-2">⚠️ Se encontraron errores:</strong>
                <ul class="list-disc ml-6 text-sm">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('basic_sciences.administratives.update', $administrative) }}"
              method="POST"
              class="grid grid-cols-1 md:grid-cols-2 gap-6">

            @csrf
            @method('PUT')

            <div class="col-span-2">
                <label class="font-semibold mb-1 block text-[#0B3D7E]">Usuario Administrativo</label>
                <input type="text"
                       name="administrative_user"
                       value="{{ $administrative->administrative_user }}"
                       class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-[#0B3D7E]"
                       required>
            </div>

            <div>
                <label class="font-semibold mb-1 block text-[#0B3D7E]">Nombre</label>
                <input type="text"
                       name="name"
                       value="{{ $administrative->name }}"
                       class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-[#0B3D7E]"
                       required>
            </div>

            <div>
                <label class="font-semibold mb-1 block text-[#0B3D7E]">Apellido Paterno</label>
                <input type="text"
                       name="last_name_f"
                       value="{{ $administrative->last_name_f }}"
                       class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-[#0B3D7E]"
                       required>
            </div>

            <div>
                <label class="font-semibold mb-1 block text-[#0B3D7E]">Apellido Materno</label>
                <input type="text"
                       name="last_name_m"
                       value="{{ $administrative->last_name_m }}"
                       class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-[#0B3D7E]"
                       required>
            </div>

            <div>
                <label class="font-semibold mb-1 block text-[#0B3D7E]">Puesto</label>
                <input type="text"
                       name="position"
                       value="{{ $administrative->position }}"
                       class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-[#0B3D7E]"
                       required>
            </div>

            
            <div class="col-span-2">
                <label class="font-semibold mb-1 block text-[#0B3D7E]">Carrera (opcional)</label>
                <select name="career_id"
                        class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-[#0B3D7E]">
                    <option value="">Sin carrera</option>

                    @foreach($careers as $c)
                        <option value="{{ $c->career_id }}"
                            {{ $administrative->career_id == $c->career_id ? 'selected' : '' }}>
                            {{ $c->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="col-span-2 mt-4">
                <button type="submit"
                        class="w-full py-3 text-white font-bold rounded-lg shadow-lg transition 
                               hover:opacity-90"
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

