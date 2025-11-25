<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Maestro</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- NAVBAR --}}
    <x-basic-sciences-navbar />

    <div class="w-full max-w-4xl mx-auto bg-white shadow-xl rounded-xl p-10 mt-8">

        <h1 class="text-4xl font-extrabold text-[#0B3D7E] mb-8 flex items-center gap-2">
            ✏️ Editar Maestro
        </h1>

        {{-- MENSAJES DE ERROR --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-300 text-red-700 p-5 rounded-lg mb-6 shadow">
                <strong class="block mb-2">⚠️ Se encontraron errores:</strong>
                <ul class="list-disc ml-6 space-y-1 text-sm">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('basic_sciences.teachers.update', $teacher) }}"
              method="POST"
              enctype="multipart/form-data"
              class="grid grid-cols-1 md:grid-cols-2 gap-6">

            @csrf
            @method('PUT')

            {{-- USUARIO --}}
            <div class="col-span-2">
                <label class="font-semibold block mb-1 text-[#0B3D7E]">Usuario:</label>
                <div class="block mb-2 p-3 bg-gray-100 border rounded-lg text-gray-700">
                    {{ $teacher->teacher_user }}
                </div>
            </div>

            {{-- NOMBRE --}}
            <div>
                <label class="font-semibold block mb-1 text-[#0B3D7E]">Nombre(s):</label>
                <input type="text"
                       name="name"
                       value="{{ old('name', $teacher->name) }}"
                       class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-[#0B3D7E]"
                       required>
            </div>

            {{-- APELLIDO PATERNO --}}
            <div>
                <label class="font-semibold block mb-1 text-[#0B3D7E]">Apellido Paterno:</label>
                <input type="text"
                       name="last_name_f"
                       value="{{ old('last_name_f', $teacher->last_name_f) }}"
                       class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-[#0B3D7E]"
                       required>
            </div>

            {{-- APELLIDO MATERNO --}}
            <div>
                <label class="font-semibold block mb-1 text-[#0B3D7E]">Apellido Materno:</label>
                <input type="text"
                       name="last_name_m"
                       value="{{ old('last_name_m', $teacher->last_name_m) }}"
                       class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-[#0B3D7E]"
                       required>
            </div>

            {{-- GRADO --}}
            <div>
                <label class="font-semibold block mb-1 text-[#0B3D7E]">Grado de estudios:</label>
                <input type="text"
                       name="degree"
                       value="{{ old('degree', $teacher->degree) }}"
                       class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-[#0B3D7E]"
                       required>
            </div>

            {{-- TUTOR --}}
            <div>
                <label class="font-semibold block mb-1 text-[#0B3D7E]">¿Es tutor?</label>
                <select name="tutor"
                        class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-[#0B3D7E]">
                    <option value="0" {{ $teacher->tutor == 0 ? 'selected' : '' }}>No</option>
                    <option value="1" {{ $teacher->tutor == 1 ? 'selected' : '' }}>Sí</option>
                </select>
            </div>

            {{-- DEPARTAMENTO --}}
            <div>
                <label class="font-semibold block mb-1 text-[#0B3D7E]">¿Tiene horas en Ciencias Básicas?</label>
                <select name="science_department"
                        class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-[#0B3D7E]">
                    <option value="0" {{ $teacher->science_department == 0 ? 'selected' : '' }}>No</option>
                    <option value="1" {{ $teacher->science_department == 1 ? 'selected' : '' }}>Sí</option>
                </select>
            </div>

            {{-- CARRERA --}}
            <div class="col-span-2">
                <label class="font-semibold block mb-1 text-[#0B3D7E]">Carrera:</label>
                <select name="career_id"
                        class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-[#0B3D7E]">
                    <option value="">Seleccione una carrera</option>

                    @foreach ($careers as $career)
                        <option value="{{ $career->career_id }}"
                            {{ $teacher->career_id == $career->career_id ? 'selected' : '' }}>
                            {{ $career->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- HORARIO ACTUAL --}}
            <div class="col-span-2">
                <label class="font-semibold block mb-1 text-[#0B3D7E]">Horario actual:</label>

                @if ($teacher->schedule)
                    <a href="{{ asset('storage/' . $teacher->schedule) }}"
                       download
                       class="text-blue-600 hover:underline block mb-2">
                        📄 Descargar horario actual
                    </a>
                @else
                    <p class="text-gray-500 mb-2">No hay archivo de horario cargado.</p>
                @endif
            </div>

            {{-- NUEVO HORARIO --}}
            <div class="col-span-2">
                <label class="font-semibold block mb-1 text-[#0B3D7E]">Nuevo horario:</label>
                <input type="file"
                       name="schedule"
                       class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-[#0B3D7E]">
            </div>

            {{-- BOTONES --}}
            <div class="col-span-2 flex justify-between gap-4 mt-6">

                <a href="{{ route('basic_sciences.teachers.index') }}"
                   class="w-1/2 text-center py-3 font-bold rounded-lg shadow text-white hover:opacity-90"
                   style="background-color:#6C757D;">
                    Cancelar
                </a>

                <button type="submit"
                        class="w-1/2 py-3 text-white font-bold rounded-lg shadow hover:opacity-90"
                        style="background-color:#28A745;">
                    Guardar cambios
                </button>
            </div>

        </form>

    </div>

    {{-- FOOTER --}}
    <x-basic-sciences-footer />

</body>
</html>



