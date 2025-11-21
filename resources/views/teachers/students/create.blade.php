<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Alumno</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <x-teachers-navbar/>
    <div class="flex-grow p-6">

<div class="max-w-3xl mx-auto bg-white shadow-lg rounded-xl p-8">

    {{-- Título --}}
    <h1 class="text-3xl font-bold text-gray-800 mb-6">📝 Registrar Alumno</h1>

    {{-- Errores --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded mb-6">
            <strong class="font-semibold">Corrige los siguientes errores:</strong>
            <ul class="list-disc list-inside mt-2">
                @foreach ($errors->all() as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Formulario --}}
    <form method="POST" action="{{ route('teachers.students.store') }}" enctype="multipart/form-data" class="grid grid-cols-1 md:grid-cols-2 gap-6">
        @csrf

        {{-- MATRÍCULA --}}
        <div class="col-span-2">
            <label class="block text-sm font-medium text-gray-700">Matrícula:</label>
            <input type="text" 
                   name="enrollment" 
                   value="{{ old('enrollment') }}" 
                   required
                   class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>

        {{-- Apellido paterno --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Apellido Paterno:</label>
            <input type="text" 
                   name="last_name_f" 
                   value="{{ old('last_name_f') }}" 
                   required
                   class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>

        {{-- Apellido materno --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Apellido Materno:</label>
            <input type="text" 
                   name="last_name_m" 
                   value="{{ old('last_name_m') }}" 
                   required
                   class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>

        {{-- Nombre --}}
        <div class="col-span-2">
            <label class="block text-sm font-medium text-gray-700">Nombre:</label>
            <input type="text" 
                   name="name" 
                   value="{{ old('name') }}" 
                   required
                   class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>

        {{-- Semestre --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Semestre:</label>
            <input type="number" 
                   name="semester" 
                   value="{{ old('semester') }}" 
                   required
                   class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>

        {{-- Grupo --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Grupo:</label>
            <input type="text" 
                   name="group" 
                   value="{{ old('group') }}" 
                   required
                   class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>

        {{-- Género --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Género:</label>
            <select name="gender" required 
                class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">Seleccione uno</option>
                <option value="Masculino" {{ old('gender')=='Masculino' ? 'selected':'' }}>Masculino</option>
                <option value="Femenino" {{ old('gender')=='Femenino' ? 'selected':'' }}>Femenino</option>
            </select>
        </div>

        {{-- Edad --}}
        <div>
            <label class="block text-sm font-medium text-gray-700">Edad:</label>
            <input type="number" 
                   name="age" 
                   value="{{ old('age') }}" 
                   required
                   class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
        </div>

        {{-- Carrera --}}
        <div class="col-span-2">
            <label class="block text-sm font-medium text-gray-700">Carrera:</label>
            <select name="career_id" required
                class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500">
                <option value="">Seleccione...</option>
                @foreach ($careers as $career)
                    <option value="{{ $career->career_id }}" 
                        {{ old('career_id') == $career->career_id ? 'selected':'' }}>
                        {{ $career->career_name ?? $career->name ?? $career->career }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label>Horario del alumno (PDF / Imagen):</label>
<input type="file" name="schedule_file" class="border rounded p-2 mb-4 w-full">
<br><br>

        </div>

        {{-- Botón --}}
        <div class="col-span-2 flex justify-end">
            <button type="submit"
                class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
                Guardar Alumno
            </button>
        </div>
    </form>

    {{-- Volver --}}
    <div class="mt-6">
        <a href="{{ route('teachers.students.index') }}" 
           class="text-blue-600 hover:text-blue-800 font-medium">
            ← Volver
        </a>
    </div>

</div>
</div>
{{-- FOOTER --}}
    <x-basic-sciences-footer />

</body>
</html>
