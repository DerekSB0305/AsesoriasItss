<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Maestro</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 p-8 min-h-screen flex items-center justify-center">

<div class="max-w-2xl w-full bg-white p-8 rounded-xl shadow-xl">

    {{-- Título --}}
    <h1 class="text-3xl font-bold text-gray-800 mb-6">
        👨‍🏫 Crear Nuevo Maestro
    </h1>

    {{-- Errores --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-700 p-4 rounded-lg mb-4">
            <strong class="block mb-2">⚠️ Corrige los siguientes errores:</strong>
            <ul class="list-disc ml-6">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- FORMULARIO --}}
    <form action="{{ route('basic_sciences.teachers.store') }}"
          method="POST" 
          enctype="multipart/form-data"
          class="grid grid-cols-1 md:grid-cols-2 gap-6">
        
        @csrf

        {{-- Usuario --}}
        <div class="col-span-2">
            <label class="font-semibold block mb-1">Usuario:</label>
            <input type="text" name="teacher_user"
                   class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-300"
                   required>
        </div>

        {{-- Nombre --}}
        <div>
            <label class="font-semibold block mb-1">Nombre(s):</label>
            <input type="text" name="name"
                   class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-300"
                   required>
        </div>

        {{-- Apellido paterno --}}
        <div>
            <label class="font-semibold block mb-1">Apellido paterno:</label>
            <input type="text" name="last_name_f"
                   class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-300"
                   required>
        </div>

        {{-- Apellido materno --}}
        <div>
            <label class="font-semibold block mb-1">Apellido materno:</label>
            <input type="text" name="last_name_m"
                   class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-300"
                   required>
        </div>

        {{-- Grado de estudios --}}
        <div>
            <label class="font-semibold block mb-1">Grado de estudios:</label>
            <input type="text" name="degree"
                   class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-300"
                   required>
        </div>

        {{-- Tutor --}}
        <div>
            <label class="font-semibold block mb-1">¿Es tutor?</label>
            <select name="tutor"
                    class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-300">
                <option value="0">No</option>
                <option value="1">Sí</option>
            </select>
        </div>

        {{-- Ciencias Básicas --}}
        <div>
            <label class="font-semibold block mb-1">¿Tiene horas de ciencias básicas?</label>
            <select name="science_department"
                    class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-300">
                <option value="0">No</option>
                <option value="1">Sí</option>
            </select>
        </div>

        {{-- Carrera --}}
        <div class="col-span-2">
            <label class="font-semibold block mb-1">Carrera:</label>
            <select name="career_id"
                    class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-300"
                    required>
                <option value="">Seleccione una carrera</option>

                @foreach($careers as $c)
                    <option value="{{ $c->career_id }}">{{ $c->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- Horario --}}
        <div class="col-span-2">
            <label class="font-semibold block mb-1">Horario (PDF/JPG/PNG):</label>
            <input type="file" name="schedule"
                   class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-300">
        </div>

        {{-- Guardar --}}
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


