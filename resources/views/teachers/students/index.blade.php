<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Alumnos</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- NAVBAR --}}
    <div class="fixed top-0 left-0 w-full z-50 shadow">
        <x-teachers-navbar />
    </div>

    <main class="flex-1 mt-28 mb-16 px-4">

        <div class="max-w-7xl mx-auto bg-white shadow-xl rounded-xl p-6 sm:p-8">

            {{-- HEADER --}}
            <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">

                <a href="{{ route('teachers.index') }}"
                    class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg font-semibold text-center">
                    ← Volver al inicio
                </a>

                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0B3D7E]">
                    👨‍🏫 Mis Alumnos
                </h1>

                <a href="{{ route('teachers.students.create') }}"
                    class="px-4 py-2 bg-[#28A745] hover:bg-[#218838] text-white rounded-lg shadow font-semibold">
                    ➕ Registrar Alumno
                </a>

            </div>

            {{-- MENSAJE DE ÉXITO --}}
            @if (session('success'))
                <div class="bg-green-100 border border-green-300 text-green-800 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif

            {{-- TABLA --}}
            <div class="overflow-x-auto rounded-xl border border-gray-200 shadow">

                <table class="min-w-full text-xs sm:text-sm">

                    <thead class="text-white uppercase font-semibold" style="background-color:#0B3D7E;">
                        <tr>
                            <th class="px-4 py-3 whitespace-nowrap">Matrícula</th>
                            <th class="px-4 py-3 whitespace-nowrap">Nombre</th>
                            <th class="px-4 py-3 whitespace-nowrap">Semestre</th>
                            <th class="px-4 py-3 whitespace-nowrap">Grupo</th>
                            <th class="px-4 py-3 whitespace-nowrap">Género</th>
                            <th class="px-4 py-3 whitespace-nowrap">Edad</th>
                            <th class="px-4 py-3 whitespace-nowrap">Carrera</th>
                            <th class="px-4 py-3 whitespace-nowrap">Horario</th>
                            <th class="px-4 py-3 text-center whitespace-nowrap">Acciones</th>
                        </tr>
                    </thead>

                    <tbody class="text-gray-800">

                        @forelse ($students as $student)
                        <tr class="border-b hover:bg-gray-50 transition">

                            <td class="px-4 py-3 font-semibold">{{ $student->enrollment }}</td>

                            <td class="px-4 py-3 whitespace-nowrap">
                                {{ $student->last_name_f }}
                                {{ $student->last_name_m }}
                                {{ $student->name }}
                            </td>

                            <td class="px-4 py-3 text-center">{{ $student->semester }}</td>

                            <td class="px-4 py-3 text-center">{{ $student->group }}</td>

                            <td class="px-4 py-3 text-center">{{ $student->gender }}</td>

                            <td class="px-4 py-3 text-center">{{ $student->age }}</td>

                            <td class="px-4 py-3 text-center">
                                {{ $student->career->name ?? '---' }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                @if ($student->schedule_file)
                                    <a href="{{ asset('storage/'.$student->schedule_file) }}" 
                                       target="_blank"
                                       class="text-blue-600 hover:text-blue-800 underline">
                                       📄 Ver horario
                                    </a>
                                @else
                                    <span class="text-gray-500">---</span>
                                @endif
                            </td>

                            {{-- ACCIONES --}}
                            <td class="px-4 py-3 text-center">
                                <div class="flex flex-col sm:flex-row gap-2 justify-center">

                                    {{-- Editar --}}
                                    <a href="{{ route('teachers.students.edit', $student->enrollment) }}"
                                        class="px-3 py-1 rounded-lg text-white shadow font-semibold"
                                        style="background-color:#F39C12;">
                                        ✏ Editar
                                    </a>

                                    {{-- Eliminar --}}
                                    <form action="{{ route('teachers.students.destroy', $student->enrollment) }}"
                                          method="POST"
                                          onsubmit="return confirm('¿Eliminar alumno?')">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                            class="px-3 py-1 rounded-lg text-white shadow font-semibold"
                                            style="background-color:#E74C3C;">
                                            🗑 Eliminar
                                        </button>
                                    </form>

                                </div>
                            </td>

                        </tr>
                        @empty
                        <tr>
                            <td colspan="9" class="text-center py-4 text-gray-500">
                                No hay alumnos registrados aún.
                            </td>
                        </tr>
                        @endforelse

                    </tbody>
                </table>

            </div>

            {{-- PAGINACIÓN --}}
            <div class="mt-6 flex justify-center">
                {{ $students->links('vendor.pagination.tailwind') }}
            </div>

        </div>

    </main>

    <x-basic-sciences-footer />

</body>
</html>
