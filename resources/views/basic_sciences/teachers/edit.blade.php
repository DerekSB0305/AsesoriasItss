<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Maestro</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

<x-basic-sciences-navbar />

<main class="flex-grow">

    <div class="w-full mx-auto bg-white shadow-xl rounded-xl 
                p-6 sm:p-8 mt-6 mb-10
                max-w-md sm:max-w-lg md:max-w-2xl lg:max-w-4xl">

        <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0B3D7E] mb-6 flex items-center gap-2">
            ✏️ Editar Maestro
        </h1>

        {{-- ERRORES --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-300 text-red-700 p-4 rounded-lg text-sm">
                <strong class="block mb-2">⚠️ Se encontraron errores:</strong>
                <ul class="list-disc ml-6 space-y-1">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('basic_sciences.teachers.update', $teacher) }}"
              method="POST"
              enctype="multipart/form-data"
              class="grid grid-cols-1 md:grid-cols-2 gap-4 sm:gap-6">

            @csrf
            @method('PUT')
            <div class="md:col-span-2">
                <label class="font-semibold block mb-1 text-[#0B3D7E]">Usuario:</label>
                <div class="w-full p-3 border rounded-lg bg-gray-100 text-gray-700">
                    {{ $teacher->teacher_user }}
                </div>
            </div>
            <div>
                <label class="font-semibold block mb-1 text-[#0B3D7E]">Nombre(s):</label>
                <input type="text"
                       name="name"
                       value="{{ old('name', $teacher->name) }}"
                       class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-[#0B3D7E]"
                       required>
            </div>

            <div>
                <label class="font-semibold block mb-1 text-[#0B3D7E]">Apellido Paterno:</label>
                <input type="text"
                       name="last_name_f"
                       value="{{ old('last_name_f', $teacher->last_name_f) }}"
                       class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-[#0B3D7E]"
                       required>
            </div>

            <div>
                <label class="font-semibold block mb-1 text-[#0B3D7E]">Apellido Materno:</label>
                <input type="text"
                       name="last_name_m"
                       value="{{ old('last_name_m', $teacher->last_name_m) }}"
                       class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-[#0B3D7E]"
                       required>
            </div>

            <div>
                <label class="font-semibold block mb-1 text-[#0B3D7E]">Grado de estudios:</label>
                <input type="text"
                       name="degree"
                       value="{{ old('degree', $teacher->degree) }}"
                       class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-[#0B3D7E]"
                       required>
            </div>

            <div>
                <label class="font-semibold block mb-1 text-[#0B3D7E]">¿Es tutor?</label>
                <select name="tutor"
                        class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-[#0B3D7E]">
                    <option value="0" {{ $teacher->tutor == 0 ? 'selected' : '' }}>No</option>
                    <option value="1" {{ $teacher->tutor == 1 ? 'selected' : '' }}>Sí</option>
                </select>
            </div>

            <div>
                <label class="font-semibold block mb-1 text-[#0B3D7E]">¿Tiene horas en Ciencias Básicas?</label>
                <select name="science_department"
                        class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-[#0B3D7E]">
                    <option value="0" {{ $teacher->science_department == 0 ? 'selected' : '' }}>No</option>
                    <option value="1" {{ $teacher->science_department == 1 ? 'selected' : '' }}>Sí</option>
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="font-semibold block mb-1 text-[#0B3D7E]">Carrera:</label>
                <select name="career_id"
                        class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-[#0B3D7E]">
                    <option value="">Seleccione una carrera</option>
                    @foreach ($careers as $career)
                        <option value="{{ $career->career_id }}"
                            {{ $teacher->career_id == $career->career_id ? 'selected' : '' }}>
                            {{ $career->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="md:col-span-2">
                <label class="font-semibold block mb-1 text-[#0B3D7E]">Horario actual:</label>

                @if ($teacher->schedule)
                    <a href="{{ asset('storage/' . $teacher->schedule) }}"
                       download
                       class="text-blue-600 hover:underline block mb-2">
                        📄 Descargar horario actual
                    </a>
                @else
                    <p class="text-gray-500">No hay archivo cargado.</p>
                @endif
            </div>

            <div class="md:col-span-2">
                <label class="font-semibold block mb-1 text-[#0B3D7E]">Nuevo horario:</label>
                <input type="file"
                       name="schedule"
                       class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-[#0B3D7E]">
            </div>

            <div class="md:col-span-2 flex flex-col sm:flex-row justify-between gap-3 mt-4">

                <a href="{{ route('basic_sciences.teachers.index') }}"
                   class="w-full sm:w-1/2 py-3 text-center text-white font-bold rounded-lg shadow hover:opacity-90"
                   style="background-color:#6C757D;">
                    Cancelar
                </a>

                <button type="submit"
                        class="w-full sm:w-1/2 py-3 text-white font-bold rounded-lg shadow hover:opacity-90"
                        style="background-color:#28A745;">
                    Guardar cambios
                </button>

            </div>

        </form>

    </div>

</main>

{{-- FOOTER --}}
<x-basic-sciences-footer />

</body>
</html>



