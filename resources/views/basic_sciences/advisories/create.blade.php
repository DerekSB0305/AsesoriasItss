<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Asesoría</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 p-10">

<div class="max-w-3xl mx-auto bg-white p-8 rounded shadow">
    <h2 class="text-2xl font-bold mb-5 text-blue-700">Registrar Asesoría</h2>

    {{-- Información del alumno y la solicitud --}}
    <div class="mb-6 p-4 bg-gray-100 rounded">
        <p><strong>Alumno:</strong> {{ $detail->request->student->name }} {{ $detail->request->student->last_name_f }}</p>
        <p><strong>Materia solicitada:</strong> {{ $detail->request->subject->name }}</p>
        <p><strong>Estado del detalle:</strong> {{ $detail->status }}</p>
    </div>

    <form method="POST" action="{{ route('basic_sciences.advisories.store') }}" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="advisory_detail_id" value="{{ $detail->advisory_detail_id }}">

        {{-- Maestro que dará la asesoría --}}
        <label class="block font-medium">Maestro asignado:</label>
        <select name="teacher_subject_id" class="w-full border rounded p-2 mb-4" required>
            <option value="">Seleccione un maestro</option>
            @foreach($teacherSubjects as $ts)
                <option value="{{ $ts->teacher_subject_id }}">
                    {{ $ts->teacher->name }} {{ $ts->teacher->last_name_f }} —
                    {{ $ts->subject->name }} ({{ $ts->career->name }})
                </option>
            @endforeach
        </select>

        {{-- Fecha y hora --}}
        <label class="block font-medium">Fecha y Hora:</label>
        <input type="datetime-local" name="schedule" class="w-full border rounded p-2 mb-4"required>

        {{-- Salón --}}
        <label class="block font-medium">Salón:</label>
        <input type="text" name="classroom" class="w-full border rounded p-2 mb-4">

        {{-- Edificio --}}
        <label class="block font-medium">Edificio:</label>
        <input type="text" name="building" class="w-full border rounded p-2 mb-4">

        {{-- Archivo --}}
        <label class="block font-medium">Archivo (opcional):</label>
        <input type="file" name="assignment_file" class="w-full border rounded p-2 mb-4">

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Guardar Asesoría
        </button>
    </form>

</div>

</body>
</html>

