<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Detalle Asesoría</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 p-8">
    <h1 class="text-2xl font-bold mb-4">Registrar Detalle de Asesoría</h1>

    <form method="POST" action="{{ route('basic_sciences.advisory_details.store') }}" class="bg-white p-6 rounded shadow-md space-y-4">
        @csrf

        <div>
            <label class="block font-medium">Alumno:</label>
            <select name="student_enrollment" class="w-full border rounded p-2" required>
                <option value="">Seleccione un alumno</option>
                @foreach($students as $student)
                    <option value="{{ $student->enrollment }}">{{ $student->first_name }} {{ $student->last_name_father }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-medium">Materia:</label>
            <select name="subject_id" class="w-full border rounded p-2" required>
                <option value="">Seleccione una materia</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block font-medium">Estado:</label>
            <select name="status" class="w-full border rounded p-2" required>
                <option value="Pendiente">Pendiente</option>
                <option value="Aprobada">Aprobada</option>
                <option value="Rechazada">Rechazada</option>
            </select>
        </div>

        <div>
            <label class="block font-medium">Observaciones:</label>
            <textarea name="observations" class="w-full border rounded p-2"></textarea>
        </div>

        <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
            Guardar y Continuar
        </button>
    </form>
</body>
</html>
