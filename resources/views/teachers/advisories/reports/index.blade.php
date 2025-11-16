<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Reportes</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen p-6">

<div class="max-w-5xl mx-auto bg-white shadow-lg rounded-xl p-8">

    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">📄 Mis Reportes de Asesorías</h1>

        <a href="{{ route('teachers.advisories.index') }}"
           class="text-green-600 hover:text-green-800 font-medium">
            ← Volver a asesorías
        </a>
    </div>

    @if ($reports->count() == 0)
        <p class="text-center text-gray-600 py-6 text-lg">
            No has subido reportes aún.
        </p>
    @else

    <div class="overflow-x-auto">
        <table class="w-full border-collapse rounded-lg overflow-hidden shadow-sm">

            <thead class="bg-gray-200 text-gray-700 text-sm uppercase">
                <tr>
                    <th class="px-4 py-3">Asesoría</th>
                    <th class="px-4 py-3">Tipo</th>
                    <th class="px-4 py-3">Archivo</th>
                    <th class="px-4 py-3">Fecha subida</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
            </thead>

            <tbody class="text-gray-700">

                @foreach ($reports as $r)
                    <tr class="border-b hover:bg-gray-50 transition">

                        <td class="px-4 py-3">
                            {{ $r->advisory->teacherSubject->subject->name }}
                            <span class="text-sm text-gray-500">
                                ({{ $r->advisory->schedule }})
                            </span>
                        </td>

                        <td class="px-4 py-3 font-semibold">
                            @if ($r->report_type == 'previo')
                                <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded text-xs">
                                    Previo
                                </span>
                            @else
                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded text-xs">
                                    Final
                                </span>
                            @endif
                        </td>

                        <td class="px-4 py-3">
    <a href="{{ asset('storage/' . $r->file_path) }}" download class="text-blue-600 hover:underline">
        📄 Descargar
    </a>
</td>


                        <td class="px-4 py-3">
                            {{ $r->created_at->format('Y-m-d H:i') }}
                        </td>

                        <td class="px-4 py-3 text-center">
                            <a href="{{ route('teachers.advisories.reports.edit', $r->id) }}"
                               class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600">
                                Editar
                            </a>
                        </td>

                    </tr>
                @endforeach

            </tbody>
        </table>
    </div>

    @endif

</div>

</body>
</html>
