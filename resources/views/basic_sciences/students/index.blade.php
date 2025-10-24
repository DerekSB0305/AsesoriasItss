<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Estudiantes</title>
</head>
<body>
    <h1>Lista de Estudiantes</h1>

    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>Matrícula</th>
                 <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                 <th>Carrera</th>
                <th>Semestre</th>
                <th>Grupo</th>
                <th>Materia</th>
                <th>Género</th>
                <th>Edad</th>
                <th>Maestro tutor</th>
                <th>Horario</th>
                <th>Horario de asesoria</th>
                <th>Asesor</th>
                <th>evaluacion</th>
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