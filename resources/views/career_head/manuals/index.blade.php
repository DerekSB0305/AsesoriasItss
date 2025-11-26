<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manuales de Maestros de mi Carrera</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- NAVBAR --}}
    <div class="fixed top-0 left-0 w-full z-50">
        <x-career-head-navbar />
    </div>

<main class="flex-1 mt-28 mb-12 px-4">

    <div class="w-[95%] max-w-6xl mx-auto bg-white shadow-lg rounded-xl p-6 sm:p-8">

        <h1 class="text-2xl sm:text-3xl font-bold text-[#0B3D7E] mb-6">
            📘 Manuales de Maestros de mi Carrera
        </h1>

        <div class="flex flex-col sm:flex-row sm:justify-between gap-3 mb-6">
            <a href="{{ route('career_head.index') }}"
               class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg font-semibold text-center">
                ← Volver al inicio
            </a>
        </div>

        <!-- TABLA RESPONSIVA -->
        <div class="overflow-x-auto rounded-xl border shadow">

            <table class="min-w-max w-full text-sm sm:text-base border-collapse">

                <thead style="background-color:#0B3D7E;" class="text-white font-bold">
                    <tr>
                        <th class="px-4 py-3 text-left whitespace-nowrap">Título</th>
                        <th class="px-4 py-3 text-left whitespace-nowrap">Maestro</th>
                        <th class="px-4 py-3 text-left whitespace-nowrap">Materia</th>
                        <th class="px-4 py-3 text-center whitespace-nowrap">Archivo</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700">

                    @foreach ($manuals as $m)
                    <tr class="border-b hover:bg-gray-50 transition">

                        <!-- Título -->
                        <td class="px-4 py-3 font-semibold">
                            {{ $m->title }}
                        </td>

                        <!-- Maestro -->
                        <td class="px-4 py-3 whitespace-nowrap">
                            {{ $m->teacherSubject->teacher->name }}
                            {{ $m->teacherSubject->teacher->last_name_f }}
                            {{ $m->teacherSubject->teacher->last_name_m }}
                        </td>

                        <!-- Materia -->
                        <td class="px-4 py-3 whitespace-nowrap">
                            {{ $m->teacherSubject->subject->name }}
                        </td>

                        <!-- Archivo -->
                        <td class="px-4 py-3 text-center">
                            <a href="{{ asset('storage/'.$m->file_path) }}"
                               target="_blank"
                               class="text-blue-600 hover:text-blue-800 font-semibold">
                                📄 Ver
                            </a>
                        </td>

                    </tr>
                    @endforeach

                </tbody>

            </table>

        </div>
    </div>

</main>

<x-basic-sciences-footer />

</body>
</html>

