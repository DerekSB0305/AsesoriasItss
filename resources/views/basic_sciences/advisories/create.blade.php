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

    <form method="POST" action="{{ route('basic_sciences.advisories.store') }}" enctype="multipart/form-data" class="space-y-4">
        @csrf

        <input type="hidden" name="advisory_detail_id" value="{{ $detail->advisory_detail_id }}">

        <div>
            <label class="block text-sm font-medium">Maestro - Materia - Carrera</label>
            <select name="teacher_subject_id" class="w-full border rounded p-2" required>
                <option value="">Seleccione una opción</option>
                @foreach($teacherSubjects as $ts)
                    <option value="{{ $ts->teacher_subject_id }}">
                        {{ $ts->teacher->name ?? 'Maestro' }}
                        —
                        {{ $ts->subject->name ?? 'Materia' }}
                        —
                        {{ $ts->career->name ?? 'Carrera' }}
                    </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium">Fecha y hora de la asesoría</label>
            <input type="datetime-local" name="schedule" class="w-full border rounded p-2" required>
        </div>

        <div>
            <label class="block text-sm font-medium">Edificio</label>
            <input type="text" name="building" class="w-full border rounded p-2" maxlength="10">
        </div>

        <div>
            <label class="block text-sm font-medium">Aula</label>
            <input type="text" name="classroom" class="w-full border rounded p-2" maxlength="10">
        </div>

        <div>
            <label class="block text-sm font-medium">Archivo de evidencia / tarea</label>
            <input type="file" name="assignment_file" accept=".pdf,.doc,.docx,.jpg,.jpeg,.png">
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Guardar asesoría
        </button>
    </form>
</div>
</body>
</html>

