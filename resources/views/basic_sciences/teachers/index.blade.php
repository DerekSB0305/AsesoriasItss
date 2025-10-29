<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Maestros</title>
</head>
<body>
    <h1>Lista de Maestros</h1>

    <a href="{{ route('basic_sciences.teachers.create') }}">Agregar Maestro</a>

    <table border="1" cellpadding="5" cellspacing="0">
        <thead>
            <tr>
                <th>Usuario</th>
                <th>Nombre(s)</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Grado de Estudios</th>
                <th>Tutor</th>
                <th>Ciencias Basicas</th>
                <th>Carrera</th>
                <th>Reporte</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($teachers as $teacher)
                <tr>
                    <td>{{ $teacher->teacher_user }}</td>
                    <td>{{ $teacher->name }}</td>
                    <td>{{ $teacher->last_name_f }}</td>
                    <td>{{ $teacher->last_name_m }}</td>
                    <td>{{ $teacher->degree }}</td>
                    <td>{{ $teacher->tutor ? 'Sí' : 'No' }}</td>
                    <td>{{ $teacher->science_department ? 'Sí' : 'No' }}</td>
                    <td>{{ $teacher->career->name ?? 'Sin carrera' }}</td>
                    <td>{{ $teacher->report }}</td>
                    <td>
                        <a href="{{ route('basic_sciences.teachers.edit', $teacher) }}">Editar</a> |
                        <form action="{{ route('basic_sciences.teachers.destroy', $teacher) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Eliminar</button>
                        </form> |
                        <a href="{{ route('basic_sciences.teachers.show', $teacher) }}">Ver</a>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    
</body>
</html>