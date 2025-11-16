<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Reporte</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen p-6">

<div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6">

    <h2 class="text-2xl font-bold mb-4">✏️ Editar Reporte</h2>

    <p class="mb-2">
        <strong>Materia:</strong> {{ $report->advisory->teacherSubject->subject->name }}
    </p>

    <p class="mb-4">
        <strong>Fecha/Hora:</strong> {{ $report->advisory->schedule }}
    </p>

    <form action="{{ route('teachers.advisories.reports.update', $report->id) }}"
          method="POST" enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <label class="block font-medium">Tipo de reporte:</label>
        <select name="report_type" class="border rounded p-2 mb-4 w-full" required>
            <option value="previo" {{ $report->report_type == 'previo' ? 'selected' : '' }}>Previo</option>
            <option value="final" {{ $report->report_type == 'final' ? 'selected' : '' }}>Final</option>
        </select>

        <label class="block font-medium mb-2">Archivo actual:</label>
        <a class="text-blue-600 underline" href="{{ asset('storage/' . $report->file_path) }}" download>
            📄 Descargar archivo
        </a>

        <label class="block font-medium mt-4">Subir nuevo archivo (opcional):</label>
        <input type="file" name="file" class="border rounded p-2 mb-4 w-full">

        <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Actualizar
        </button>

    </form>

    <form action="{{ route('teachers.advisories.reports.destroy', $report->id) }}"
          method="POST" class="mt-4"
          onsubmit="return confirm('¿Eliminar este reporte?')">
        @csrf
        @method('DELETE')

        <button class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-700">
            Eliminar reporte
        </button>
    </form>

</div>

</body>
</html>
