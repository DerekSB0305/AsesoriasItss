<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reportes de Asesoría</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
    <x-teachers-navbar/>

    <div class="flex-grow p-6">

        <div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6">

            {{-- Encabezado --}}
            <h2 class="text-2xl font-bold mb-4 text-gray-800">
                📘 Reportes — {{ $advisory->teacherSubject->subject->name }}
            </h2>

            {{-- Información de la asesoría --}}
            <p class="mb-4 text-gray-600">
                <strong>Fecha:</strong>
                {{ \Carbon\Carbon::parse($advisory->start_date)->format('d/m/Y') }}
                —
                {{ \Carbon\Carbon::parse($advisory->end_date)->format('d/m/Y') }}
                <br>
                <strong>Horario:</strong>
                {{ ucfirst($advisory->day_of_week) }} 
                {{ \Carbon\Carbon::parse($advisory->start_time)->format('H:i') }}
                -
                {{ \Carbon\Carbon::parse($advisory->end_time)->format('H:i') }}
            </p>

            <a href="{{ route('teachers.advisories.index') }}"
                class="text-green-600 hover:text-green-800 mb-6 inline-block font-semibold">
                ← Volver
            </a>

            {{-- Si no hay reportes --}}
            @if ($reports->count() == 0)

                <p class="text-gray-500 text-lg">
                    No hay reportes subidos para esta asesoría.
                </p>

            @else

                <table class="w-full border-collapse rounded-lg overflow-hidden">
                    <thead class="bg-gray-200 text-gray-700 text-sm uppercase">
                        <tr>
                            <th class="px-4 py-2">Descripción</th>
                            <th class="px-4 py-2">Archivo</th>
                            <th class="px-4 py-2">Fecha subida</th>
                            <th class="px-4 py-2 text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody class="text-gray-700">
                        @foreach ($reports as $r)
                        <tr class="border-b hover:bg-gray-50 transition">

                            {{-- Descripción --}}
                            <td class="px-4 py-2">
                                {{ $r->description ? $r->description : '---' }}
                            </td>

                            {{-- Archivo --}}
                            <td class="px-4 py-2">
                                <a href="{{ asset('storage/'.$r->file_path) }}"
                                    download
                                    class="text-blue-600 hover:underline">
                                    📄 Descargar
                                </a>
                            </td>

                            {{-- Fecha --}}
                            <td class="px-4 py-2">
                                {{ $r->created_at->format('d/m/Y H:i') }}
                            </td>

                            {{-- Acciones --}}
                            <td class="px-4 py-2 text-center flex gap-3 justify-center">

                                {{-- EDITAR --}}
                                <a href="{{ route('teachers.advisories.reports.edit', $r->id) }}"
                                    class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 text-sm">
                                    ✏️ Editar
                                </a>

                                {{-- ELIMINAR --}}
                                <form action="{{ route('teachers.advisories.reports.destroy', $r->id) }}"
                                      method="POST"
                                      onsubmit="return confirm('¿Eliminar este reporte?');">
                                    @csrf
                                    @method('DELETE')

                                    <button class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700 text-sm">
                                        🗑️ Eliminar
                                    </button>
                                </form>

                            </td>

                        </tr>
                        @endforeach
                    </tbody>

                </table>

            @endif

        </div>

    </div>

    <x-basic-sciences-footer />
</body>
</html>
