<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Asesoría</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 p-8">
<div class="max-w-4xl mx-auto bg-white rounded shadow p-6">

    <h1 class="text-2xl font-bold mb-4">Crear Asesoría</h1>

    {{-- ALERTA GLOBAL DE ERRORES --}}
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 rounded p-3 mb-4">
            <strong>Se encontraron errores:</strong>
            <ul class="list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>• {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <div class="bg-green-100 text-green-800 border border-green-300 rounded-md p-3 mb-4">
            {{ session('success') }}
        </div>
    @endif

    <h2 class="font-semibold mb-2">Alumnos incluidos:</h2>
    <ul class="list-disc list-inside mb-4">
        @foreach($detail->students as $stu)
            <li>{{ $stu->enrollment }} — {{ $stu->name }} {{ $stu->last_name_f }}</li>
        @endforeach
    </ul>

    <form method="POST" action="{{ route('basic_sciences.advisories.store') }}"
          enctype="multipart/form-data" class="space-y-4">

        @csrf

        <input type="hidden" name="advisory_detail_id" value="{{ $detail->advisory_detail_id }}">

        {{-- Maestro - Materia - Carrera --}}
        <div>
            <label class="block text-sm font-medium">Maestro - Materia - Carrera</label>
            <select name="teacher_subject_id" class="w-full border rounded p-2">
                <option value="">Seleccione una opción</option>
                @foreach($teacherSubjects as $ts)
                    <option value="{{ $ts->teacher_subject_id }}"
                        {{ old('teacher_subject_id') == $ts->teacher_subject_id ? 'selected' : '' }}>
                        {{ $ts->teacher->name }} — {{ $ts->subject->name }} — {{ $ts->career->name }}
                    </option>
                @endforeach
            </select>

            @error('teacher_subject_id')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Fecha y hora --}}
        <div>
            <label class="block text-sm font-medium">Fecha y hora de la asesoría</label>
            <input type="datetime-local" name="schedule" class="w-full border rounded p-2"
                   value="{{ old('schedule') }}">

            @error('schedule')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Edificio --}}
        <div>
            <label class="block text-sm font-medium">Edificio</label>
            <input type="text" name="building" class="w-full border rounded p-2"
                   value="{{ old('building') }}" maxlength="10">

            @error('building')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Aula --}}
        <div>
            <label class="block text-sm font-medium">Aula</label>
            <input type="text" name="classroom" class="w-full border rounded p-2"
                   value="{{ old('classroom') }}" maxlength="10">

            @error('classroom')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Archivo --}}
        <div>
            <label class="block text-sm font-medium">Archivo de evidencia / tarea</label>
            <input type="file" name="assignment_file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">

            @error('assignment_file')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit"
                class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Guardar asesoría
        </button>

    </form>
</div>
</body>
</html>
