<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Lista de Estudiantes</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen p-6">

<div class="max-w-7xl mx-auto bg-white shadow-xl rounded-xl p-8">

    {{-- ENCABEZADO --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">📚 Lista de Estudiantes</h1>

        <a href="{{ route('basic_sciences.index') }}"
           class="text-green-600 hover:text-green-800 font-semibold">
            ← Volver al inicio
        </a>
    </div>

    {{-- TABLA --}}
    <div class="overflow-x-auto">
        <table class="w-full border-collapse rounded-lg overflow-hidden shadow">

            {{-- HEAD --}}
            <thead style="background-color:#0B3D7E;">
                <tr>
                    <th class="px-4 py-3 text-white font-bold text-sm">Matrícula</th>
                    <th class="px-4 py-3 text-white font-bold text-sm">Nombre</th>
                    <th class="px-4 py-3 text-white font-bold text-sm">Apellido Paterno</th>
                    <th class="px-4 py-3 text-white font-bold text-sm">Apellido Materno</th>
                    <th class="px-4 py-3 text-white font-bold text-sm">Carrera</th>
                    <th class="px-4 py-3 text-white font-bold text-sm">Semestre</th>
                    <th class="px-4 py-3 text-white font-bold text-sm">Grupo</th>
                    <th class="px-4 py-3 text-white font-bold text-sm">Materia</th>
                    <th class="px-4 py-3 text-white font-bold text-sm">Género</th>
                    <th class="px-4 py-3 text-white font-bold text-sm">Edad</th>
                    <th class="px-4 py-3 text-white font-bold text-sm">Maestro Tutor</th>
                    <th class="px-4 py-3 text-white font-bold text-sm">Horario</th>
                    <th class="px-4 py-3 text-white font-bold text-sm">Horario Asesoría</th>
                    <th class="px-4 py-3 text-white font-bold text-sm">Asesor</th>
                    <th class="px-4 py-3 text-white font-bold text-sm">Evaluación</th>
                    <th class="px-4 py-3 text-white font-bold text-sm text-center">Acciones</th>
                </tr>
            </thead>

            {{-- BODY --}}
            <tbody class="text-gray-700">

                @foreach ($students as $student)
                <tr class="border-b hover:bg-gray-50 transition">

                    <td class="px-4 py-3">{{ $student->enrollment }}</td>

                    <td class="px-4 py-3">{{ $student->name }}</td>
                    <td class="px-4 py-3">{{ $student->last_name_f }}</td>
                    <td class="px-4 py-3">{{ $student->last_name_m }}</td>

                    <td class="px-4 py-3">
                        {{ $student->career->name ?? 'N/A' }}
                    </td>

                    <td class="px-4 py-3">{{ $student->semester }}</td>
                    <td class="px-4 py-3">{{ $student->group }}</td>

                    <td class="px-4 py-3">
                        {{ $student->request->subject->name ?? 'N/A' }}
                    </td>

                    <td class="px-4 py-3">{{ $student->gender }}</td>
                    <td class="px-4 py-3">{{ $student->age }}</td>

                    <td class="px-4 py-3">
                        {{ $student->teacher->name ?? 'N/A' }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $student->schedule ?? 'N/A' }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $student->advisory_schedule ?? 'N/A' }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $student->advisor ?? 'N/A' }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $student->evaluation ?? 'N/A' }}
                    </td>

                    <td class="px-4 py-3 text-center">
                        <a href="#"
                           class="bg-blue-600 text-white px-3 py-1 rounded hover:bg-blue-700 text-sm">
                           Ver Evaluación
                        </a>
                    </td>

                </tr>
                @endforeach

            </tbody>
        </table>
    </div>

</div>

</body>
</html>
