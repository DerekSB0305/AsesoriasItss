<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Materias asignadas a maestros</title>
</head>
<body>

<h1>Asignaciones de Materias por Maestro</h1>

@if(session('success'))
    <p style="color:green;font-weight:bold;">{{ session('success') }}</p>
@endif

<table border="1" cellpadding="6">
    <thead>
        <tr>
            <th>Maestro</th>
            <th>Materia</th>
            <th>Carrera</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>

        @foreach($teacherSubjects as $ts)
        <tr>
            <td>{{ $ts->teacher->name }} {{ $ts->teacher->last_name_f }} {{ $ts->teacher->last_name_m }}</td>
            <td>{{ $ts->subject->name }}</td>
            <td>{{ $ts->career->name }}</td>

            <td>

                {{-- EDITAR --}}
                <a href="{{ route('basic_sciences.teacher_subjects.edit', $ts->teacher_subject_id) }}">
                    Editar
                </a>

                &nbsp;|&nbsp;

                {{-- ELIMINAR --}}
                <form method="POST"
                      action="{{ route('basic_sciences.teacher_subjects.destroy', $ts->teacher_subject_id) }}"
                      style="display:inline;">
                    @csrf
                    @method('DELETE')

                    <button type="submit" onclick="return confirm('¿Eliminar esta asignación?')">
                        Eliminar
                    </button>
                </form>

            </td>
        </tr>
        @endforeach

    </tbody>
</table>

<br>
<a href="{{ route('basic_sciences.teacher_subjects.create') }}">➕ Nueva asignación</a>
<a href="{{ route('basic_sciences.index') }}">🔙 Volver al inicio</a>

</body>
</html>


