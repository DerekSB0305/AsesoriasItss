<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Maestro</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <x-basic-sciences-navbar />

    <div class="w-full max-w-4xl mx-auto bg-white shadow-xl rounded-xl p-10 mt-8">

        <h1 class="text-4xl font-extrabold text-[#0B3D7E] mb-8 flex items-center gap-2">
            ✏️ Editar Maestro
        </h1>

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

            <div class="col-span-2">
                <label class="font-semibold block mb-1 text-[#0B3D7E]">Usuario:</label>
                <input type="text"
                       name="teacher_user"
                       value="{{ $teacher->teacher_user }}"
                       class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-[#0B3D7E]"
                       required>
            </div>

            <div>
                <label class="font-semibold block mb-1 text-[#0B3D7E]">Nombre(s):</label>
                <input type="text"
                       name="name"
                       value="{{ $teacher->name }}"
                       class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-[#0B3D7E]"
                       required>
            </div>

            
            <div>
                <label class="font-semibold block mb-1 text-[#0B3D7E]">Apellido Paterno:</label>
                <input type="text"
                       name="last_name_f"
                       value="{{ $teacher->last_name_f }}"
                       class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-[#0B3D7E]"
                       required>
            </div>

            <div>
                <label class="font-semibold block mb-1 text-[#0B3D7E]">Apellido Materno:</label>
                <input type="text"
                       name="last_name_m"
                       value="{{ $teacher->last_name_m }}"
                       class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-[#0B3D7E]"
                       required>
            </div>

            <div>
                <label class="font-semibold block mb-1 text-[#0B3D7E]">Grado de estudios:</label>
                <input type="text"
                       name="degree"
                       value="{{ $teacher->degree }}"
                       class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-[#0B3D7E]"
                       required>
            </div>

            <div>
                <label class="font-semibold block mb-1 text-[#0B3D7E]">¿Es tutor?</label>
                <select name="tutor"
                        class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-[#0B3D7E]">
                    <option value="0" {{ !$teacher->tutor ? 'selected' : '' }}>No</option>
                    <option value="1" {{ $teacher->tutor ? 'selected' : '' }}>Sí</option>
                </select>
            </div>

            <div>
                <label class="font-semibold block mb-1 text-[#0B3D7E]">¿Tiene horas en Ciencias Básicas?</label>
                <select name="science_department"
                        class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-[#0B3D7E]">
                    <option value="0" {{ !$teacher->science_department ? 'selected' : '' }}>No</option>
                    <option value="1" {{ $teacher->science_department ? 'selected' : '' }}>Sí</option>
                </select>
            </div>

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

            <div class="col-span-2">
                <label class="font-semibold block mb-1 text-[#0B3D7E]">Nuevo horario (opcional):</label>
                <input type="file"
                       name="schedule"
                       class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-[#0B3D7E]">
            </div>

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
    
    <x-basic-sciences-footer />

</body>
</html>

