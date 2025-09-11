<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lista de Materias</title>
</head>
<body>
    <h1>Lista de Materias</h1>

    <a href="{{ route('subjects.create') }}">Registrar Materia</a>

    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nombre</th>
                <th>Créditos</th>
                <th>Carrera</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($subjects as $subject)
                <tr>
                    <td>{{ $subject->id }}</td>
                    <td>{{ $subject->name }}</td>
                    <td>{{ $subject->credits }}</td>
                    <td>{{ $subject->career->name ?? 'N/A' }}</td>
                    <td>
                        
                        <a href="{{ route('subjects.edit', $subject) }}">Editar</a>
                        <form action="{{ route('subjects.destroy', $subject) }}" method="POST" style="display:inline;">
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
