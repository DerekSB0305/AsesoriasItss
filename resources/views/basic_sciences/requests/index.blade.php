<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitudes</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
    
    <div class="fixed top-0 left-0 w-full z-50 shadow">
        <x-basic-sciences-navbar />
    </div>

<main class="flex-1 mt-28 mb-20 px-4">

    <div class="max-w-7xl mx-auto bg-white shadow-xl rounded-xl p-6 sm:p-8">

        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-3 mb-6">
            <h1 class="text-2xl sm:text-3xl font-bold text-gray-800">📄 Lista de Solicitudes</h1>

            <a href="{{ route('basic_sciences.index') }}"
               class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold text-center">
                ← Volver al inicio
            </a>
        </div>

        <form method="GET" class="flex flex-col md:flex-row gap-3 mb-6">
            <input type="text"
                   name="buscar"
                   value="{{ request('buscar') }}"
                   placeholder="Buscar por matrícula, materia o carrera..."
                   class="px-4 py-2 border rounded-lg w-full md:w-96 focus:ring-2 focus:ring-[#0B3D7E]">

            <button class="px-4 py-2 bg-[#159a82] text-white rounded-lg shadow hover:bg-[#107a68]">
                🔍 Buscar
            </button>
        </form>

        <div class="overflow-x-auto rounded-lg shadow border border-gray-200">

            <table class="w-full table-auto text-sm">

                <thead class="bg-[#0B3D7E] text-white text-xs sm:text-sm">
                    <tr>
                        <th class="px-3 py-3">Matrícula</th>
                        <th class="px-3 py-3">Nombre</th>
                        <th class="px-3 py-3">A. Paterno</th>
                        <th class="px-3 py-3">A. Materno</th>
                        <th class="px-3 py-3">Carrera</th>
                        <th class="px-3 py-3">Sem.</th>
                        <th class="px-3 py-3">Grupo</th>
                        <th class="px-3 py-3">Asunto</th>
                        <th class="px-3 py-3 whitespace-nowrap">Materia</th>
                        <th class="px-3 py-3">Tutor</th>
                        <th class="px-3 py-3">Hoja canalización</th>
                        <th class="px-3 py-3 text-center">Acción</th>
                    </tr>
                </thead>

                <tbody class="text-gray-800 text-xs sm:text-sm">

                    @foreach ($requests as $request)
                    <tr class="border-b hover:bg-gray-50 transition">

                        <td class="px-3 py-3">{{ $request->student->enrollment }}</td>

                        <td class="px-3 py-3">{{ $request->student->name }}</td>
                        <td class="px-3 py-3">{{ $request->student->last_name_f }}</td>
                        <td class="px-3 py-3">{{ $request->student->last_name_m }}</td>

                        <td class="px-3 py-3">
                            {{ $request->student->career->name ?? 'N/A' }}
                        </td>

                        <td class="px-3 py-3">{{ $request->student->semester }}</td>
                        <td class="px-3 py-3">{{ $request->student->group ?? 'N/A' }}</td>

                        <td class="px-3 py-3">{{ $request->reason }}</td>

                        <td class="px-3 py-3 whitespace-nowrap">
                            {{ $request->subject->name }}
                        </td>

                        <td class="px-3 py-3">
                            {{ $request->teacher->name ?? 'N/A' }}
                        </td>

                        <td class="px-3 py-3">
                            @if($request->canalization_file)
                                <a href="{{ asset('storage/' . $request->canalization_file) }}"
                                   class="text-blue-600 hover:underline"
                                   target="_blank">
                                    Ver Hoja
                                </a>
                            @else
                                <span class="text-gray-500">No disponible</span>
                            @endif
                        </td>

                        <td class="px-3 py-3 text-center">
                            <a href="{{ route('basic_sciences.advisory_details.create', ['subject_id' => $request->subject_id]) }}"
                                class="inline-block px-4 py-2 rounded-full bg-gradient-to-r from-green-500 to-emerald-600 text-white font-semibold shadow-md text-xs sm:text-sm
                                hover:from-green-600 hover:to-emerald-700 hover:shadow-lg transform hover:-translate-y-0.5 transition-all duration-200">
                                ➕ Crear asesoría
                            </a>
                        </td>

                    </tr>
                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</main>

 <div class="w-full mt-10">
    <x-basic-sciences-footer />
</div>

</body>
</html>


