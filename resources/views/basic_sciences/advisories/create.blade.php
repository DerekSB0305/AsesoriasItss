<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva Asesoría</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 p-8">
    <h1 class="text-2xl font-bold mb-4 text-gray-800">Registrar Nueva Asesoría</h1>

    <form method="POST" action="{{ route('basic_sciences.advisories.store') }}" class="bg-white p-6 rounded-lg shadow-md space-y-4">
        @csrf

        <input type="hidden" name="advisory_detail_id" value="{{ $detailId }}">

        <div>
            <label class="block font-medium text-gray-700">Profesor:</label>
            <select name="teacher_user" class="w-full border rounded-lg p-2" required>
                <option value="">Seleccione un profesor</option>
                @foreach($teachers as $teacher)
                    <option value="{{ $teacher->teacher_user }}">{{ $teacher->first_name }} {{ $teacher->last_name_father }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-medium text-gray-700">Materia:</label>
            <input type="number" name="subject_id" class="w-full border rounded-lg p-2" placeholder="ID de la materia (temporal)" required>
        </div>

        <div>
            <label class="block font-medium text-gray-700">Horario:</label>
            <input type="datetime-local" name="schedule" class="w-full border rounded-lg p-2" required>
        </div>

        <div class="flex gap-4">
            <div class="flex-1">
                <label class="block font-medium text-gray-700">Aula:</label>
                <input type="text" name="classroom" class="w-full border rounded-lg p-2" required>
            </div>
            <div class="flex-1">
                <label class="block font-medium text-gray-700">Edificio:</label>
                <input type="text" name="building" class="w-full border rounded-lg p-2" required>
            </div>
        </div>

        <div>
            <label class="block font-medium text-gray-700">Ficha de Asignación (opcional):</label>
            <input type="text" name="assignment_sheet" class="w-full border rounded-lg p-2">
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
                Guardar Asesoría
            </button>
        </div>
    </form>
</body>
</html>

