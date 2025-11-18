<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Materias asignadas a maestros</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 p-8">

<div class="max-w-6xl mx-auto bg-white shadow-lg rounded-xl p-8">

    {{-- TÍTULO --}}
    <h1 class="text-3xl font-bold mb-6 text-gray-800">
        📚 Asignaciones de Materias por Maestro
    </h1>

    {{-- BOTONES SUPERIORES --}}
    <div class="flex justify-between mb-6">
        <a href="{{ route('basic_sciences.teacher_subjects.create') }}"
           class="px-4 py-2 rounded text-white font-semibold shadow hover:opacity-90"
           style="background-color:#28A745;">
            ➕ Nueva asignación
        </a>

        <a href="{{ route('basic_sciences.index') }}"
           class="text-blue-600 hover:text-blue-800 font-medium">
            🔙 Volver al inicio
        </a>
    </div>

    {{-- MENSAJE DE ÉXITO --}}
    @if(session('success'))
    <div class="bg-green-100 border border-green-300 text-green-700 p-3 rounded mb-4">
        {{ session('success') }}
    </div>
    @endif

    {{-- BUSCADOR --}}
    <form method="GET" class="mb-6">
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

            <input type="text" name="search_teacher"
                   placeholder="Buscar por maestro..."
                   value="{{ request('search_teacher') }}"
                   class="p-2 border rounded-lg">

            <input type="text" name="search_subject"
                   placeholder="Buscar por materia..."
                   value="{{ request('search_subject') }}"
                   class="p-2 border rounded-lg">

            <input type="text" name="search_career"
                   placeholder="Buscar por carrera..."
                   value="{{ request('search_career') }}"
                   class="p-2 border rounded-lg">

        </div>

        <button class="mt-3 px-4 py-2 bg-blue-600 text-white font-semibold rounded-lg hover:bg-blue-700">
            🔍 Buscar
        </button>
    </form>

    {{-- TABLA --}}
    <div class="overflow-x-auto">
        <table class="w-full border-collapse shadow rounded-lg overflow-hidden">

            <thead style="background-color:#0B3D7E;">
                <tr class="text-white font-bold">
                    <th class="px-4 py-3">Maestro</th>
                    <th class="px-4 py-3">Materia</th>
                    <th class="px-4 py-3">Carrera</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
            </thead>

            <tbody class="text-gray-800">

                @foreach($teacherSubjects as $ts)
                <tr class="border-b hover:bg-gray-100 transition">

                    <td class="px-4 py-3">
                        {{ $ts->teacher->name }} {{ $ts->teacher->last_name_f }} {{ $ts->teacher->last_name_m }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $ts->subject->name }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $ts->career->name }}
                    </td>

                    <td class="px-4 py-3 text-center flex justify-center gap-3">

                        {{-- EDITAR --}}
                        <a href="{{ route('basic_sciences.teacher_subjects.edit', $ts->teacher_subject_id) }}"
                           class="px-3 py-1 text-white font-semibold rounded hover:opacity-90"
                           style="background-color:#F39C12;">
                            Editar
                        </a>

                        {{-- ELIMINAR --}}
                        <form method="POST"
                              action="{{ route('basic_sciences.teacher_subjects.destroy', $ts->teacher_subject_id) }}"
                              onsubmit="return confirmDelete()">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="px-3 py-1 text-white font-semibold rounded hover:opacity-90"
                                    style="background-color:#E74C3C;">
                                Eliminar
                            </button>
                        </form>

                    </td>

                </tr>
                @endforeach

            </tbody>
        </table>
    </div>

</div>

{{-- CONFIRMACIÓN PERSONALIZADA --}}
<script>
function confirmDelete() {
    return confirm('❗ ¿Seguro que deseas eliminar esta asignación?');
}
</script>

</body>
</html>


