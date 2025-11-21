<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Manuales de Materias</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
    <x-teachers-navbar/>

     <div class="flex-grow p-6">

    <div class="max-w-5xl mx-auto bg-white p-8 rounded-xl shadow-lg">

        {{-- Título --}}
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">📘 Manuales de Mis Materias</h1>

            <a href="{{ route('teachers.index') }}"
               class="text-indigo-600 hover:text-indigo-800 font-medium">
                ← Volver al panel
            </a>
        </div>

        {{-- Botón para subir manual --}}
        <div class="flex justify-end mb-4">
            <a href="{{ route('teachers.manuals.select_subject') }}"
               class="bg-indigo-600 text-white px-4 py-2 rounded-lg shadow hover:bg-indigo-700">
                ➕ Subir manual
            </a>
        </div>

        {{-- Si no hay manuales --}}
        @if ($manuals->count() == 0)
            <p class="text-center text-gray-600 text-lg py-6">
                No tienes manuales subidos aún.
            </p>
        @else

            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse shadow">
                    <thead class="bg-gray-200 text-gray-700 uppercase text-sm">
                        <tr>
                            <th class="px-4 py-3">Materia</th>
                            <th class="px-4 py-3">Manual</th>
                            <th class="px-4 py-3">Archivo</th>
                            <th class="px-4 py-3 text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody class="text-gray-700">
                        @foreach ($manuals as $manual)
                            <tr class="border-b hover:bg-gray-50">

                                <td class="px-4 py-3 font-semibold">
                                    {{ $manual->teacherSubject->subject->name }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $manual->title }}
                                </td>

                                <td class="px-4 py-3">
                                    <a href="{{ asset('storage/' . $manual->file_path) }}"
                                       class="text-blue-600 hover:underline"
                                       target="_blank">
                                        Ver archivo
                                    </a>
                                </td>

                                <td class="px-4 py-3 text-center">
                                    <form action="{{ route('teachers.manuals.destroy', $manual->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('¿Eliminar este manual?')">
                                        @csrf
                                        @method('DELETE')

                                        <button class="bg-red-600 text-white px-3 py-1 rounded hover:bg-red-700">
                                            Eliminar
                                        </button>
                                    </form>
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        @endif

    </div>
    </div>
    <x-basic-sciences-footer />

</body>
</html>
