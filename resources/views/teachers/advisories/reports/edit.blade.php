<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Reporte</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen p-6">

<div class="max-w-3xl mx-auto bg-white shadow-lg rounded-xl p-8">

    <h2 class="text-3xl font-bold mb-6 text-gray-800">
        ✏️ Editar Reporte
    </h2>

    <p class="text-gray-700 mb-3">
        <strong>Asesoría:</strong>
        {{ $report->advisory->teacherSubject->subject->name }}
    </p>

    <p class="text-gray-700 mb-3">
        <strong>Tipo:</strong>
        {{ ucfirst($report->report_type) }}
    </p>

    <p class="text-gray-700 mb-6">
        <strong>Archivo actual:</strong>
        <a href="{{ asset('storage/reports/'.$report->file) }}"
           target="_blank"
           class="text-blue-600 hover:underline">
            Descargar
        </a>
    </p>

    @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg">
            <ul class="list-disc pl-6">
                @foreach ($errors->all() as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('teachers.advisories.reports.update', $report->id) }}"
          method="POST" enctype="multipart/form-data">

        @csrf
        @method('PUT')

        <label class="block font-semibold mb-2">
            Reemplazar archivo (PDF/DOC máx 4MB):
        </label>

        <input type="file"
               name="file"
               class="border-gray-300 rounded-lg p-3 w-full shadow mb-6 bg-white">

        <button class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700">
            Actualizar Reporte
        </button>

    </form>

</div>

</body>
</html>
