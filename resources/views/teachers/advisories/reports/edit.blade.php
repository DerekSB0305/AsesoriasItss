<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Reporte</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
    <x-teachers-navbar/>

    <div class="flex-grow p-6">

        <div class="max-w-3xl mx-auto bg-white shadow-md rounded-lg p-6">

            <h2 class="text-2xl font-bold mb-4 text-gray-800">✏️ Editar Reporte</h2>

            {{-- Información de la asesoría --}}
            <div class="bg-gray-50 p-4 rounded-lg border mb-6">
                <p class="mb-2 text-gray-700">
                    <strong class="text-gray-900">Materia:</strong>
                    {{ $report->advisory->teacherSubject->subject->name }}
                </p>

                <p class="mb-1 text-gray-700">
                    <strong class="text-gray-900">Periodo:</strong>
                    {{ \Carbon\Carbon::parse($report->advisory->start_date)->format('d/m/Y') }}
                    —
                    {{ \Carbon\Carbon::parse($report->advisory->end_date)->format('d/m/Y') }}
                </p>

                <p class="text-gray-700">
                    <strong class="text-gray-900">Horario:</strong>
                    {{ ucfirst($report->advisory->day_of_week) }}
                    {{ \Carbon\Carbon::parse($report->advisory->start_time)->format('H:i') }}
                    -
                    {{ \Carbon\Carbon::parse($report->advisory->end_time)->format('H:i') }}
                </p>
            </div>

            {{-- Formulario --}}
            <form action="{{ route('teachers.advisories.reports.update', $report->id) }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="space-y-6">

                @csrf
                @method('PUT')

                {{-- Descripción --}}
                <div>
                    <label class="block font-semibold text-gray-800 mb-1">
                        Descripción del reporte:
                    </label>

                    <textarea name="description"
                              class="border-gray-300 rounded-lg p-3 w-full shadow-sm focus:ring-blue-500 focus:border-blue-500"
                              rows="3"
                              placeholder="Ejemplo: Reporte preliminar, actividades realizadas, conclusiones..."
                    >{{ old('description', $report->description) }}</textarea>
                </div>

                {{-- Archivo actual --}}
                <div>
                    <label class="block font-semibold text-gray-800 mb-1">
                        Archivo actual:
                    </label>

                    <a class="text-blue-600 underline"
                       href="{{ asset('storage/' . $report->file_path) }}"
                       target="_blank">
                        📄 Descargar archivo
                    </a>
                </div>

                {{-- Subir nuevo archivo --}}
                <div>
                    <label class="block font-semibold text-gray-800 mb-1">
                        Subir nuevo archivo (opcional):
                    </label>

                    <input type="file"
                           name="file"
                           class="border-gray-300 rounded-lg p-3 w-full shadow-sm bg-white focus:ring-blue-500 focus:border-blue-500">
                </div>

                {{-- Botón actualizar --}}
                <div class="text-right">
                    <button class="bg-blue-600 text-white px-6 py-3 rounded-lg shadow hover:bg-blue-700 transition">
                        💾 Actualizar reporte
                    </button>
                </div>

            </form>

            {{-- ELIMINAR REPORTE --}}
            <form action="{{ route('teachers.advisories.reports.destroy', $report->id) }}"
                  method="POST"
                  class="mt-6"
                  onsubmit="return confirm('¿Eliminar este reporte permanentemente?')">

                @csrf
                @method('DELETE')

                <button class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                    🗑️ Eliminar reporte
                </button>
            </form>

        </div>

    </div>

    <x-basic-sciences-footer />
</body>
</html>
