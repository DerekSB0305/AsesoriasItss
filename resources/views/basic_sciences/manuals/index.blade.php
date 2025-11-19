<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Manuales de Maestros</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

<x-basic-sciences-navbar />

<div class="max-w-6xl mx-auto bg-white shadow-lg rounded-xl p-8 mt-10 mb-14">

    <h1 class="text-3xl font-bold text-[#0B3D7E] mb-6 flex items-center gap-2">
        📘 Manuales Subidos por Maestros
    </h1>

    <a href="{{ route('basic_sciences.index') }}"
    class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold text-center">
    ← Volver al inicio
    </a>

    <div class="overflow-x-auto mt-4">
        <table class="w-full border-collapse shadow text-sm">

            <thead style="background-color:#0B3D7E;" class="text-white font-bold">
                <tr>
                    <th class="px-4 py-3 text-left">Título</th>
                    <th class="px-4 py-3 text-left">Maestro</th>
                    <th class="px-4 py-3 text-left">Materia</th>
                    <th class="px-4 py-3 text-left">Carrera</th>
                    <th class="px-4 py-3 text-left">Fecha de subida</th>
                    <th class="px-4 py-3 text-center">Archivo</th>
                </tr>
            </thead>

            <tbody class="text-gray-700">

                @foreach($manuals as $m)
                    <tr class="border-b hover:bg-gray-50 transition">

                        {{-- TITULO --}}
                        <td class="px-4 py-3 font-semibold">
                            {{ $m->title }}
                        </td>

                        {{-- MAESTRO --}}
                        <td class="px-4 py-3">
                            {{ $m->teacherSubject->teacher->name }}
                            {{ $m->teacherSubject->teacher->last_name_f }}
                            {{ $m->teacherSubject->teacher->last_name_m }}
                        </td>

                        {{-- MATERIA --}}
                        <td class="px-4 py-3">
                            {{ $m->teacherSubject->subject->name }}
                        </td>

                        {{-- CARRERA --}}
                        <td class="px-4 py-3">
                            {{ $m->teacherSubject->subject->career->name }}
                        </td>

                        {{-- FECHA --}}
                        <td class="px-4 py-3">
                            {{ $m->created_at->format('d/m/Y') }}
                        </td>

                        {{-- VER ARCHIVO --}}
                        <td class="px-4 py-3 text-center">

                            <a href="{{ asset('storage/' . $m->file_path) }}"
                               target="_blank"
                               class="px-3 py-1 rounded text-white"
                               style="background-color:#007BFF;">
                                👁 Ver
                            </a>

                            <a href="{{ asset('storage/' . $m->file_path) }}"
                               download
                               class="px-3 py-1 ml-2 rounded text-white"
                               style="background-color:#28A745;">
                                ⬇ Descargar
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
