<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Estudiantes</title>
</head>
<body>
    <h1>Lista de Estudiantes</h1>

    <a href="{{ route('students.create') }}">Registrar Estudiante</a>

    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>Matrícula</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Nombre</th>
                <th>Semestre</th>
                <th>Carrera</th>
                <th>Género</th>
                <th>Edad</th>
                <th>Asesor</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($students as $student)
                <tr>
                    <td>{{ $student->enrollment }}</td>
                    <td>{{ $student->last_name_father }}</td>
                    <td>{{ $student->last_name_mother }}</td>
                    <td>{{ $student->first_name }}</td>
                    <td>{{ $student->semester }}</td>
                    <td>{{ $student->career->name ?? 'N/A' }}</td>
                    <td>{{ $student->gender }}</td>
                    <td>{{ $student->age }}</td>
                    <td>{{ $student->teacher->first_name ?? 'N/A' }}</td>
                    <td>
                        {{-- <a href="{{ route('students.show', $student->enrollment) }}">Ver</a> | --}}
                        <a href="{{ route('students.edit', $student->enrollment) }}">Editar</a>
                        <form action="{{ route('students.destroy', $student->enrollment) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
