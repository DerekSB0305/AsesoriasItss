<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Manuales de Materias</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

     <div class="flex-grow p-6">

<div class="max-w-5xl mx-auto bg-white p-8 rounded-xl shadow-lg">

    <a href="{{ route('students.panel.index') }}"
       class="text-indigo-600 hover:text-indigo-800 text-sm">
        ← Regresar al panel
    </a>

    <h1 class="text-3xl font-bold text-gray-800 mt-4 mb-6">
        📘 Manuales de Mis Materias
    </h1>

    @if ($manuals->count() == 0)
        <p class="text-center text-gray-600 text-lg">
            No hay manuales disponibles para tu carrera por el momento.
        </p>
    @else

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse shadow">

                <thead class="bg-gray-200 text-gray-700 uppercase text-sm">
                    <tr>
                        <th class="px-4 py-3">Materia</th>
                        <th class="px-4 py-3">Manual</th>
                        <th class="px-4 py-3 text-center">Archivo</th>
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

                            <td class="px-4 py-3 text-center">
                                <a href="{{ asset('storage/' . $manual->file_path) }}"
                                   target="_blank"
                                   class="text-blue-600 hover:underline">
                                    Descargar
                                </a>
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
