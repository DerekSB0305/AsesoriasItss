<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Asesoría</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 p-8">
<div class="max-w-4xl mx-auto bg-white shadow rounded p-6">

    <h1 class="text-2xl font-bold mb-4">Editar Asesoría</h1>

    {{-- ALERTA GLOBAL DE ERRORES --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4">
            <strong>Se encontraron errores:</strong>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('basic_sciences.advisories.update', $advisory->advisory_id) }}"
          method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        @method('PUT')

        {{-- Información general --}}
        <div class="mb-3">
            <p><strong>Maestro:</strong>
                {{ $advisory->teacherSubject->teacher->name }}
                {{ $advisory->teacherSubject->teacher->last_name_f }}
            </p>

            <p><strong>Materia:</strong> {{ $advisory->teacherSubject->subject->name }}</p>
            <p><strong>Carrera:</strong> {{ $advisory->teacherSubject->career->name }}</p>
        </div>

        {{-- Fecha y hora --}}
        <div>
            <label class="block text-sm font-medium">Fecha y hora:</label>
            <input type="datetime-local" name="schedule"
                   class="w-full border rounded p-2"
                   value="{{ date('Y-m-d\TH:i', strtotime($advisory->schedule)) }}">

            @error('schedule')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Aula --}}
        <div>
            <label class="block text-sm font-medium">Aula:</label>
            <input type="text" name="classroom"
                   class="w-full border rounded p-2"
                   value="{{ $advisory->classroom }}">

            @error('classroom')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Edificio --}}
        <div>
            <label class="block text-sm font-medium">Edificio:</label>
            <input type="text" name="building"
                   class="w-full border rounded p-2"
                   value="{{ $advisory->building }}">

            @error('building')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Archivo --}}
        <div>
            <label class="block text-sm font-medium">Archivo (opcional)</label>
            <input type="file" name="assignment_file">

            @error('assignment_file')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Alumnos --}}
        <div>
            <h3 class="font-semibold mb-2">Seleccionar alumnos:</h3>

            <select name="students[]" multiple size="8"
                    class="w-full border rounded p-2">
                @foreach ($students as $stu)
                    <option value="{{ $stu['enrollment'] }}"
                        {{ in_array($stu['enrollment'], $currentStudents) ? 'selected' : '' }}>
                        {{ $stu['enrollment'] }} — {{ $stu['name'] }}
                    </option>
                @endforeach
            </select>

            <p class="text-xs text-gray-500 mt-1">
                * CTRL + clic para seleccionar varios
            </p>

            @error('students')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
                class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Guardar cambios
        </button>

    </form>

    <br>

    <a href="{{ route('basic_sciences.advisories.index') }}"
       class="text-blue-600">← Volver</a>

</div>
</body>
</html>
