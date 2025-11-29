<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manuales de Maestros de mi Carrera</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <div class="fixed top-0 left-0 w-full z-50">
        <x-career-head-navbar/>
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

        <form method="GET"
              class="bg-gray-50 p-4 rounded-lg shadow mb-6 grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

            <div>
                <label class="text-sm font-semibold">Maestro</label>
                <input type="text" name="maestro" value="{{ request('maestro') }}"
                    placeholder="Nombre o apellido"
                    class="w-full px-3 py-2 border rounded-lg focus:ring-[#0B3D7E]">
            </div>

            <div>
                <label class="text-sm font-semibold">Materia</label>
                <input type="text" name="materia" value="{{ request('materia') }}"
                    placeholder="Ej. Cálculo, Física"
                    class="w-full px-3 py-2 border rounded-lg focus:ring-[#0B3D7E]">
            </div>

            <div class="flex items-end">
                <button class="w-full px-4 py-2 bg-[#1ABC9C] text-white rounded-lg shadow hover:bg-[#159a82]">
                    🔍 Buscar
                </button>
            </div>

        </form>

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

                        <td class="px-4 py-3 font-semibold">
                            {{ $m->title }}
                        </td>

                        <td class="px-4 py-3 whitespace-nowrap">
                            {{ $m->teacherSubject->teacher->name }}
                            {{ $m->teacherSubject->teacher->last_name_f }}
                            {{ $m->teacherSubject->teacher->last_name_m }}
                        </td>

                        <td class="px-4 py-3 whitespace-nowrap">
                            {{ $m->teacherSubject->subject->name }}
                        </td>

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

        <div class="mt-6 flex justify-center">
            {{ $manuals->links('vendor.pagination.tailwind') }}
        </div>

    </div>

</main>

<x-basic-sciences-footer />

</body>
</html>


