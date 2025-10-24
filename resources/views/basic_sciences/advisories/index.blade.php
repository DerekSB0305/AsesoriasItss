<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asesorías Registradas</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 p-8">
    <h1 class="text-2xl font-bold mb-6 text-gray-800">Asesorías Registradas</h1>

    <a href="{{ route('basic_sciences.advisory_details.create') }}" 
       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
       Nueva Asesoría
    </a>

    <table class="min-w-full bg-white shadow-md mt-6 rounded-lg overflow-hidden">
        <thead class="bg-gray-200 text-gray-700">
            <tr>
                <th class="py-2 px-4 text-left">Profesor</th>
                <th class="py-2 px-4 text-left">Alumno</th>
                <th class="py-2 px-4 text-left">Materia</th>
                <th class="py-2 px-4 text-left">Horario</th>
                <th class="py-2 px-4 text-left">Aula</th>
                <th class="py-2 px-4 text-left">Estado</th>
                <th class="py-2 px-4 text-center">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($advisories as $advisory)
                <tr class="border-b hover:bg-gray-50">
                    <td class="py-2 px-4">{{ $advisory->teacher->first_name ?? 'N/A' }}</td>
                    <td class="py-2 px-4">{{ $advisory->detail->student->first_name ?? 'N/A' }}</td>
                    <td class="py-2 px-4">{{ $advisory->subject->name ?? 'N/A' }}</td>
                    <td class="py-2 px-4">{{ $advisory->schedule }}</td>
                    <td class="py-2 px-4">{{ $advisory->classroom }}</td>
                    <td class="py-2 px-4">{{ $advisory->detail->status }}</td>
                    <td class="py-2 px-4 text-center">
                        <form action="{{ route('basic_sciences.advisories.destroy', $advisory->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta asesoría?');">
                            @csrf
                            @method('DELETE')
                            <button class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center py-4 text-gray-500">No hay asesorías registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
