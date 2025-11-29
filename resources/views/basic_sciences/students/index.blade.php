<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Estudiantes</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <div class="fixed top-0 left-0 w-full z-50 shadow">
        <x-basic-sciences-navbar />
    </div>

<main class="flex-1 mt-28 mb-20 px-4">

    <div class="w-full max-w-6xl mx-auto bg-white shadow-xl rounded-xl p-6 sm:p-8">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">
                📚 Lista de Estudiantes
            </h1>

            <a href="{{ route('basic_sciences.index') }}"
               class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold text-center">
                ← Volver al inicio
            </a>
        </div>

        <form method="GET"
              class="bg-gray-50 p-4 rounded-xl shadow-sm border
                     grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">

            <div>
                <label class="text-sm font-semibold">Buscar por matrícula</label>
                <input type="text"
                       name="matricula"
                       value="{{ request('matricula') }}"
                       class="w-full px-3 py-2 mt-1 border rounded-lg focus:ring-[#0B3D7E]"
                       placeholder="Ej. 21330899">
            </div>

            <div>
                <label class="text-sm font-semibold">Buscar por nombre</label>
                <input type="text"
                       name="nombre"
                       value="{{ request('nombre') }}"
                       class="w-full px-3 py-2 mt-1 border rounded-lg focus:ring-[#0B3D7E]"
                       placeholder="Ej. Juan, María">
            </div>

            <div>
                <label class="text-sm font-semibold">Buscar por carrera</label>
                <input type="text"
                       name="carrera"
                       value="{{ request('carrera') }}"
                       class="w-full px-3 py-2 mt-1 border rounded-lg focus:ring-[#0B3D7E]"
                       placeholder="Ej. Informática, Industrial">
            </div>

            <div class="flex items-end">
                <button class="px-4 py-2 w-full bg-[#1ABC9C] hover:bg-[#159a82]
                               text-white rounded-lg shadow font-semibold flex items-center gap-2 justify-center">
                    🔍 Buscar
                </button>
            </div>

        </form>

        <div class="overflow-x-auto rounded-lg shadow border border-gray-200">

            <table class="w-full text-sm">

                <thead class="bg-[#0B3D7E] text-white text-xs sm:text-sm uppercase font-semibold">
                    <tr>
                        <th class="px-3 py-3">Matrícula</th>
                        <th class="px-3 py-3">Nombre</th>
                        <th class="px-3 py-3">A. Paterno</th>
                        <th class="px-3 py-3">A. Materno</th>
                        <th class="px-3 py-3">Carrera</th>
                        <th class="px-3 py-3">Sem.</th>
                        <th class="px-3 py-3">Grupo</th>
                        <th class="px-3 py-3">Materia</th>
                        <th class="px-3 py-3">Género</th>
                        <th class="px-3 py-3">Edad</th>
                        <th class="px-3 py-3">Tutor</th>
                        <th class="px-3 py-3 whitespace-nowrap">Horario</th>
                        <th class="px-3 py-3 whitespace-nowrap">Asesoría</th>
                        <th class="px-3 py-3">Asesor</th>
                        <th class="px-3 py-3">Evaluación</th>
                        <th class="px-3 py-3 text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700 text-xs sm:text-sm">

                    @foreach ($students as $student)
                    <tr class="border-b hover:bg-gray-50 transition">

                        <td class="px-3 py-3">{{ $student->enrollment }}</td>

                        <td class="px-3 py-3">{{ $student->name }}</td>
                        <td class="px-3 py-3">{{ $student->last_name_f }}</td>
                        <td class="px-3 py-3">{{ $student->last_name_m }}</td>

                        <td class="px-3 py-3">
                            {{ $student->career->name ?? 'N/A' }}
                        </td>

                        <td class="px-3 py-3">{{ $student->semester }}</td>
                        <td class="px-3 py-3">{{ $student->group }}</td>

                        <td class="px-3 py-3">
                            {{ $student->request->subject->name ?? 'N/A' }}
                        </td>

                        <td class="px-3 py-3">{{ $student->gender }}</td>
                        <td class="px-3 py-3">{{ $student->age }}</td>

                        <td class="px-3 py-3">
                            {{ $student->teacher->name ?? 'N/A' }}
                        </td>

                        <td class="px-3 py-3 whitespace-nowrap">
                            {{ $student->schedule ?? 'N/A' }}
                        </td>

                        <td class="px-3 py-3 whitespace-nowrap">
                            {{ $student->advisory_schedule ?? 'N/A' }}
                        </td>

                        <td class="px-3 py-3">
                            {{ $student->advisor ?? 'N/A' }}
                        </td>

                        <td class="px-3 py-3">
                            {{ $student->evaluation ?? 'N/A' }}
                        </td>

                        <td class="px-3 py-3 text-center">
                            <a href="#"
                               class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-xs sm:text-sm">
                               Ver
                            </a>
                        </td>

                    </tr>
                    @endforeach

                </tbody>

            </table>
        </div>

        <div class="mt-6 flex justify-center">
            {{ $students->links('vendor.pagination.tailwind') }}
        </div>

    </div>

</main>

<div class="w-full mt-10">
        <x-basic-sciences-footer />
    </div>

</body>
</html>

