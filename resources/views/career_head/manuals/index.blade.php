<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Manuales de Maestros de mi Carrera</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

<x-basic-sciences-navbar />

<div class="max-w-6xl mx-auto bg-white shadow-lg rounded-xl p-8 my-10">

    <h1 class="text-3xl font-bold text-[#0B3D7E] mb-6">
        📘 Manuales de Maestros de mi Carrera
    </h1>

    <div class="overflow-x-auto">
        <table class="w-full border-collapse shadow">

            <thead style="background-color:#0B3D7E;" class="text-white font-bold">
                <tr>
                    <th class="px-4 py-3 text-left">Título</th>
                    <th class="px-4 py-3 text-left">Maestro</th>
                    <th class="px-4 py-3 text-left">Materia</th>
                    <th class="px-4 py-3 text-center">Archivo</th>
                </tr>
            </thead>

            <tbody class="text-gray-700">

                @foreach ($manuals as $m)
                <tr class="border-b hover:bg-gray-50 transition">

                    <td class="px-4 py-3 font-semibold">{{ $m->title }}</td>

                    <td class="px-4 py-3">
                        {{ $m->teacherSubject->teacher->name }}
                        {{ $m->teacherSubject->teacher->last_name_f }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $m->teacherSubject->subject->name }}
                    </td>

                    <td class="px-4 py-3 text-center">
                        <a href="{{ asset('storage/'.$m->file_path) }}"
                           target="_blank"
                           class="text-blue-600 hover:text-blue-800">
                            📄 Ver
                        </a>
                    </td>

                </tr>
                @endforeach

            </tbody>

        </table>
    </div>
</div>

<x-basic-sciences-footer />

</body>
</html>
