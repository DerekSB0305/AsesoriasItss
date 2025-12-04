<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manuales de Maestros</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <div class="fixed top-0 left-0 w-full z-50 shadow">
        <x-basic-sciences-navbar />
    </div>

    <main class="flex-1 mt-32 px-4 mb-24">

        <div class="max-w-6xl mx-auto bg-white shadow-lg rounded-xl p-6 sm:p-8">

            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0B3D7E] mb-6 flex items-center gap-2">
                📘 Manuales Subidos por Maestros
            </h1>
            
            <!-- BUSCADOR -->
            <form method="GET" 
                  class="bg-gray-50 p-4 rounded-lg shadow mb-6 
                         grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">

                <div>
                    <label class="text-sm font-semibold">Buscar por maestro</label>
                    <input type="text"
                    name="maestro"
                    value="{{ request('maestro') }}"
                    class="w-full px-3 py-2 border rounded-lg focus:ring-[#0B3D7E]"
                    placeholder="Nombre o apellido">
                </div>

                <div>
                    <label class="text-sm font-semibold">Buscar por materia</label>
                    <input type="text"
                    name="materia"
                    value="{{ request('materia') }}"
                    class="w-full px-3 py-2 border rounded-lg focus:ring-[#0B3D7E]"
                    placeholder="Ej. Física, Cálculo">
                </div>

                <div class="flex items-end">
                    <button class="w-full px-4 py-2 bg-[#1ABC9C] text-white rounded-lg shadow font-semibold hover:bg-[#159a82] transition">
                        🔍 Buscar
                    </button>
                </div>

            </form>

            <a href="{{ route('basic_sciences.index') }}"
               class="inline-block px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg font-semibold transition">
                ← Volver al inicio
            </a>


            <!-- TABLA -->
            <div class="overflow-x-auto mt-6 rounded-xl border border-gray-200 shadow">

                <table class="min-w-full text-xs sm:text-sm">

                    <thead class="bg-[#0B3D7E] text-white font-semibold">
                        <tr>
                            <th class="px-4 py-3 text-left whitespace-nowrap">Título</th>
                            <th class="px-4 py-3 text-left whitespace-nowrap">Maestro</th>
                            <th class="px-4 py-3 text-left whitespace-nowrap">Materia</th>
                            <th class="px-4 py-3 text-left whitespace-nowrap">Carrera</th>
                            <th class="px-4 py-3 text-left whitespace-nowrap">Fecha</th>
                            <th class="px-4 py-3 text-center whitespace-nowrap">Archivo</th>
                        </tr>
                    </thead>

                    <tbody class="text-gray-800">
                        @foreach($manuals as $m)
                            <tr class="border-b hover:bg-gray-50 transition">

                                <td class="px-4 py-3 font-semibold">
                                    {{ $m->title }}
                                </td>

                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $m->teacherSubject->teacher->name }}
                                    {{ $m->teacherSubject->teacher->last_name_f }}
                                    {{ $m->teacherSubject->teacher->last_name_m }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $m->teacherSubject->subject->name }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $m->teacherSubject->subject->career->name ?? 'Materia común' }}
                                </td>

                                <td class="px-4 py-3 whitespace-nowrap">
                                    {{ $m->created_at->format('d/m/Y') }}
                                </td>

                                <td class="px-4 py-3 text-center flex flex-col sm:flex-row gap-2 justify-center items-center">

                                    <a href="{{ asset('storage/' . $m->file_path) }}"
                                       target="_blank"
                                       class="px-4 py-1 bg-blue-600 text-white rounded-lg font-semibold hover:bg-blue-700 transition">
                                         Ver
                                    </a>

                                    <a href="{{ asset('storage/' . $m->file_path) }}"
                                       download
                                       class="px-4 py-1 bg-green-600 text-white rounded-lg font-semibold hover:bg-green-700 transition">
                                         Descargar
                                    </a>

                                </td>

                            </tr>
                        @endforeach
                    </tbody>

                </table>

            </div>


            <!-- PAGINACIÓN -->
            <div class="mt-6 flex justify-center">
                {{ $manuals->links('vendor.pagination.tailwind') }}
            </div>

        </div>

    </main>

    <x-basic-sciences-footer />

</body>
</html>


