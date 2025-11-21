<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Reporte</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

     <div class="flex-grow p-6">

    <div class="max-w-3xl mx-auto mt-10 bg-white shadow-lg rounded-xl p-8">

        {{-- Título --}}
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-3xl font-bold text-gray-800">📄 Subir reporte de asesoría</h2>

            <a href="{{ route('teachers.advisories.index') }}"
               class="text-blue-600 hover:text-blue-800 font-semibold">
                ← Volver
            </a>
        </div>

        {{-- Información de la asesoría --}}
        <div class="bg-gray-50 p-4 rounded-lg border mb-6">
            <p class="mb-2 text-gray-700">
                <strong class="text-gray-900">Maestro:</strong>
                {{ $advisory->teacherSubject->teacher->name }}
            </p>

            <p class="mb-2 text-gray-700">
                <strong class="text-gray-900">Materia:</strong>
                {{ $advisory->teacherSubject->subject->name }}
            </p>

            <p class="text-gray-700">
                <strong class="text-gray-900">Fecha/Hora:</strong>
                {{ $advisory->schedule }}
            </p>
        </div>

        {{-- Errores --}}
        @if ($errors->any())
        <div class="mb-4 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg">
            <ul class="list-disc pl-6">
                @foreach ($errors->all() as $item)
                    <li>{{ $item }}</li>
                @endforeach
            </ul>
        </div>
        @endif


        {{-- Formulario --}}
        <form action="{{ route('teachers.advisories.reports.store', $advisory->advisory_id) }}"
              method="POST" enctype="multipart/form-data"
              class="space-y-6">

            @csrf

            {{-- Tipo de reporte --}}
            <div>
                <label class="block font-semibold text-gray-800 mb-1">
                    Tipo de reporte:
                </label>

                <select name="report_type"
                        class="border-gray-300 rounded-lg p-3 w-full shadow-sm focus:ring-blue-500 focus:border-blue-500"
                        required>
                    <option value="">Seleccione...</option>
                    <option value="previo">📘 Primer Reporte</option>
                    <option value="final">📗 Segundo Reporte</option>
                </select>
            </div>

            {{-- Archivo --}}
            <div>
                <label class="block font-semibold text-gray-800 mb-1">
                    Archivo (PDF/DOC máx 4MB):
                </label>

                <input type="file"
                       name="file"
                       class="border-gray-300 rounded-lg p-3 w-full shadow-sm bg-white focus:ring-blue-500 focus:border-blue-500"
                       required>
            </div>

            {{-- Botón --}}
            <div class="text-right">
                <button class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow hover:bg-blue-700 transition">
                    📤 Subir reporte
                </button>
            </div>

        </form>

    </div>
    </div>
<x-basic-sciences-footer />
</body>
</html>
