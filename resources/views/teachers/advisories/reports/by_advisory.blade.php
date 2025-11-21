<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reportes de Asesoría</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

     <div class="flex-grow p-6">

<div class="max-w-4xl mx-auto bg-white shadow-md rounded-lg p-6">

    <h2 class="text-2xl font-bold mb-4">
        📘 Reportes — {{ $advisory->teacherSubject->subject->name }}
    </h2>

    <p class="mb-4 text-gray-600">
        Fecha/Hora: <strong>{{ $advisory->schedule }}</strong>
    </p>

    <a href="{{ route('teachers.advisories.index') }}"
       class="text-green-600 hover:text-green-800 mb-6 inline-block">
        ← Volver
    </a>

    @if ($reports->count() == 0)
        <p class="text-gray-500">No hay reportes subidos para esta asesoría.</p>
    @else

    <table class="w-full border-collapse">
        <thead class="bg-gray-200 text-gray-700">
            <tr>
                <th class="px-4 py-2">Tipo</th>
                <th class="px-4 py-2">Archivo</th>
                <th class="px-4 py-2">Fecha subida</th>
                <th class="px-4 py-2 text-center">Acciones</th>
            </tr>
        </thead>

        <tbody>
            @foreach ($reports as $r)
            <tr class="border-b hover:bg-gray-50">

                {{-- Tipo --}}
                <td class="px-4 py-2">
                    {{ ucfirst($r->report_type) }}
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
                    {{ $r->created_at->format('Y-m-d H:i') }}
                </td>

                {{-- ACCIONES --}}
                <td class="px-4 py-2 text-center flex gap-3 justify-center">

                    {{-- EDITAR --}}
                    <a href="{{ route('teachers.advisories.reports.edit', $r->id) }}"
                       class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 text-sm">
                        ✏️ Editar
                    </a>

                    {{-- ELIMINAR --}}
                    <form action="{{ route('teachers.advisories.reports.destroy', $r->id) }}"
                          method="POST"
                          onsubmit="return confirm('¿Eliminar este reporte?')" >
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
