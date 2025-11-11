<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Estudiantes</title>
</head>
<body>
    <h1>Lista de Estudiantes</h1>

    <a href="{{ route('basic_sciences.index') }}">🔙 Volver al inicio</a>

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
                    <td>{{ $student->name }}</td>
                    <td>{{ $student->last_name_f }}</td>
                    <td>{{ $student->last_name_m }}</td>
                    <td>{{ $student->semester }}</td>
                    <td>{{ $student->career->name ?? 'N/A' }}</td>
                    <td>{{ $student->group ?? 'N/A' }}</td>
                    <td>{{ $student->request->subject->name ?? 'N/A' }}</td>
                    <td>{{ $student->gender ?? 'N/A' }}</td>
                    <td>{{ $student->age ?? 'N/A' }}</td>
                    <td>{{ $student->teacher->name ?? 'N/A' }}</td>
                    <td>{{ $student->schedule ?? 'N/A' }}</td>
                    <td>{{ $student->advisory_schedule ?? 'N/A' }}</td>
                    <td>{{ $student->advisor ?? 'N/A' }}</td>
                    <td>{{ $student->evaluation ?? 'N/A' }}</td>
                    <td>
                        {{-- <form method="POST" action="{{ route('basic_sciences.students.destroy', $student) }}">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Ver evaluacion</button>
                        </form> --}}
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>