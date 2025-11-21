<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Alumnos</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
         {{-- contenido --}}
    <div class="flex-grow p-6">
 
    <div class="max-w-6xl mx-auto bg-white shadow-lg rounded-xl p-8">

        {{-- Encabezado --}}
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">👨‍🏫 Mis Alumnos</h1>

            <a href="{{ route('teachers.students.create') }}"
               class="bg-blue-600 text-white px-4 py-2 rounded-lg shadow hover:bg-blue-700 transition">
                Registrar Alumno
            </a>
        </div>

        {{-- Mensaje de éxito --}}
        @if (session('success'))
            <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded mb-4">
                {{ session('success') }}
            </div>
        @endif


        {{-- Tabla --}}
        <div class="overflow-x-auto">
            <table class="w-full border-collapse rounded-lg overflow-hidden shadow">
                <thead class="bg-gray-200 text-gray-700 text-sm uppercase">
                    <tr>
                        <th class="px-4 py-3">Matrícula</th>
                        <th class="px-4 py-3">Nombre</th>
                        <th class="px-4 py-3">Semestre</th>
                        <th class="px-4 py-3">Grupo</th>
                        <th class="px-4 py-3">Género</th>
                        <th class="px-4 py-3">Edad</th>
                        <th class="px-4 py-3">Carrera</th>
                        <th class="px-4 py-3">Horario</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700 text-sm">
                    @forelse ($students as $student)
                        <tr class="border-b hover:bg-gray-50 transition">
                            <td class="px-4 py-3 font-medium">{{ $student->enrollment }}</td>

                            <td class="px-4 py-3">
                                {{ $student->last_name_f }}
                                {{ $student->last_name_m }}
                                {{ $student->name }}
                            </td>

                            <td class="px-4 py-3 text-center">{{ $student->semester }}</td>
                            <td class="px-4 py-3 text-center">{{ $student->group }}</td>
                            <td class="px-4 py-3 text-center">{{ $student->gender }}</td>
                            <td class="px-4 py-3 text-center">{{ $student->age }}</td>

                            <td class="px-4 py-3 text-center">
                                {{ $student->career?->name ?? '---' }}
                            </td>
                            <td>
    @if ($student->schedule_file)
        <a href="{{ asset('storage/'.$student->schedule_file) }}" class="text-blue-600">📄 Ver horario</a>
    @else
        ---
    @endif
</td>


                            <td class="px-4 py-3 text-center space-x-3">

                                {{-- Editar --}}
                                <a href="{{ route('teachers.students.edit', $student->enrollment) }}"
                                   class="text-blue-600 hover:text-blue-800 font-medium">
                                    Editar
                                </a>

                                {{-- Eliminar --}}
                                <form action="{{ route('teachers.students.destroy', $student->enrollment) }}"
                                      method="POST" class="inline">
                                    @csrf
                                    @method('DELETE')

                                    <button
                                        class="text-red-600 hover:text-red-800 font-medium"
                                        onclick="return confirm('¿Eliminar alumno?')">
                                        Eliminar
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center py-4 text-gray-500">
                                No hay alumnos registrados aún.
                            </td>
                        </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- Regresar --}}
        <div class="mt-6">
            <a href="{{ route('teachers.index') }}"
               class="text-blue-600 hover:text-blue-800 font-semibold">
                ← Volver al inicio del maestro
            </a>
        </div>

    </div>
    </div>
    
{{-- FOOTER --}}
    <x-basic-sciences-footer />
</body>

</html>
