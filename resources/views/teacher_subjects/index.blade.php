<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Asignaciones de Maestros a Materias</title>
</head>
<body>
    <h1>Asignaciones de Maestros a Materias</h1>

    <a href="{{ route('teacher_subjects.create') }}">➕ Nueva Asignación</a>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>ID</th>
                <th>Maestro</th>
                <th>Materia</th>
                <th>Carrera</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($teacherSubjects as $ts)
                <tr>
                    <td>{{ $ts->id }}</td>
                    <td>{{ $ts->teacher->first_name ?? 'N/A' }}</td>
                    <td>{{ $ts->subject->name ?? 'N/A' }}</td>
                    <td>{{ $ts->career->name ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('teacher_subjects.edit', $ts) }}">Editar</a>
                        <form action="{{ route('teacher_subjects.destroy', $ts) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Seguro que deseas eliminar esta asignación?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No hay asignaciones registradas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>
