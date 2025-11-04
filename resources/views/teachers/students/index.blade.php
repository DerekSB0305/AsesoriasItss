<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Alumnos</title>
</head>
<body>

<h2>Alumnos Registrados</h2>

@if (session('success'))
    <p style="color:green;">{{ session('success') }}</p>
@endif

<a href="{{ route('teachers.students.create') }}">Registrar Alumno</a>

<br><br>

<table border="1" cellpadding="8">
    <thead>
        <tr>
            <th>Matrícula</th>
            <th>Nombre</th>
            <th>Semestre</th>
            <th>Género</th>
            <th>Edad</th>
            <th>Carrera</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($students as $student)
            <tr>
                <td>{{ $student->enrollment }}</td>
                <td>{{ $student->last_name_f }} {{ $student->last_name_m }} {{ $student->name }}</td>
                <td>{{ $student->semester }}</td>
                <td>{{ $student->gender }}</td>
                <td>{{ $student->age }}</td>
                <td>{{ $student->career?->name ?? '---' }}</td>
                <td>
                    <form action="{{ route('teachers.students.destroy', $student->enrollment) }}" method="POST"
                          onsubmit="return confirm('¿Eliminar alumno?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="color:red;">Eliminar</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">No hay alumnos registrados aún.</td>
            </tr>
        @endforelse
    </tbody>
</table>

<br>
<a href="{{ route('teachers.index') }}">Volver al inicio del maestro</a>

</body>
</html>
