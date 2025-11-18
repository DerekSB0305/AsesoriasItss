<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Maestro</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">

<div class="max-w-3xl w-full bg-white shadow-xl rounded-xl p-8">

    {{-- TÍTULO --}}
    <h1 class="text-3xl font-bold text-gray-800 mb-6 flex items-center">
        ✏️ Editar Maestro
    </h1>

    {{-- ERRORES --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-700 p-4 rounded-lg mb-6">
            <strong class="block mb-2">⚠️ Se encontraron errores:</strong>
            <ul class="list-disc ml-6">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORMULARIO --}}
    <form action="{{ route('basic_sciences.teachers.update', $teacher) }}"
          method="POST"
          enctype="multipart/form-data"
          class="grid grid-cols-1 md:grid-cols-2 gap-6">

        @csrf
        @method('PUT')

        {{-- USUARIO --}}
        <div class="col-span-2">
            <label class="font-semibold block mb-1">Usuario:</label>
            <input type="text"
                   name="teacher_user"
                   value="{{ $teacher->teacher_user }}"
                   class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-300"
                   required>
        </div>

        {{-- NOMBRE --}}
        <div>
            <label class="font-semibold block mb-1">Nombre(s):</label>
            <input type="text"
                   name="name"
                   value="{{ $teacher->name }}"
                   class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-300"
                   required>
        </div>

        {{-- AP PATERNO --}}
        <div>
            <label class="font-semibold block mb-1">Apellido Paterno:</label>
            <input type="text"
                   name="last_name_f"
                   value="{{ $teacher->last_name_f }}"
                   class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-300"
                   required>
        </div>

        {{-- AP MATERNO --}}
        <div>
            <label class="font-semibold block mb-1">Apellido Materno:</label>
            <input type="text"
                   name="last_name_m"
                   value="{{ $teacher->last_name_m }}"
                   class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-300"
                   required>
        </div>

        {{-- GRADO --}}
        <div>
            <label class="font-semibold block mb-1">Grado de estudios:</label>
            <input type="text"
                   name="degree"
                   value="{{ $teacher->degree }}"
                   class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-300"
                   required>
        </div>

        {{-- TUTOR --}}
        <div>
            <label class="font-semibold block mb-1">¿Es tutor?</label>
            <select name="tutor"
                    class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-300">
                <option value="0" {{ !$teacher->tutor ? 'selected' : '' }}>No</option>
                <option value="1" {{ $teacher->tutor ? 'selected' : '' }}>Sí</option>
            </select>
        </div>

        {{-- CIENCIAS BÁSICAS --}}
        <div>
            <label class="font-semibold block mb-1">¿Tiene horas en Ciencias Básicas?</label>
            <select name="science_department"
                    class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-300">
                <option value="0" {{ !$teacher->science_department ? 'selected' : '' }}>No</option>
                <option value="1" {{ $teacher->science_department ? 'selected' : '' }}>Sí</option>
            </select>
        </div>

        {{-- CARRERA --}}
        <div class="col-span-2">
            <label class="font-semibold block mb-1">Carrera:</label>
            <select name="career_id"
                    class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-300">
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
            <label class="font-semibold block mb-1">Horario actual:</label>

            @if ($teacher->schedule)
                <a href="{{ asset('storage/' . $teacher->schedule) }}"
                   download
                   class="text-blue-600 hover:underline block mb-2">
                    📄 Descargar horario
                </a>
            @else
                <p class="text-gray-500 mb-2">No hay archivo cargado.</p>
            @endif
        </div>

        {{-- NUEVO HORARIO --}}
        <div class="col-span-2">
            <label class="font-semibold block mb-1">Nuevo horario (opcional):</label>
            <input type="file"
                   name="schedule"
                   class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-300">
        </div>

        {{-- BOTÓN --}}
        <div class="col-span-2 flex justify-between gap-4 mt-4">

            <a href="{{ route('basic_sciences.teachers.index') }}"class="w-1/2 text-center py-3 font-bold rounded-lg shadow text-white hover:opacity-90"
            style="background-color:#6C757D;">
                 Cancelar
            </a>
            
            <button type="submit"class="w-1/2 py-3 text-white font-bold rounded-lg shadow hover:opacity-90"
            style="background-color:#28A745;">
                Guardar Maestro
            </button>
        </div>

    </form>

</div>

</body>
</html>

