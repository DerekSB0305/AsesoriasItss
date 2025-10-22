<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Administrativos</title>
</head>
<body>
    <h1>Lista de Administrativos</h1>
                <td colspan="4">
                    <a href="{{ route('administratives.create') }}">Crear nuevo administrativo</a>
                </td>
    <table border="1">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Apellido Paterno</th>
                <th>Apellido Materno</th>
                <th>Puesto</th>
                <th>Departamento</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                
            </tr>
            @foreach ($administratives as $administrative)
                <tr>
                    <td>{{ $administrative->first_name }}</td>
                    <td>{{ $administrative->last_name_father }}</td>
                    <td>{{ $administrative->last_name_mother }}</td>
                    <td>{{ $administrative->position }}</td>
                    <td>{{ $administrative->department->name ?? 'N/A' }}</td>
                    <td>
                        <a href="{{ route('administratives.edit', $administrative) }}">Editar</a>
                        <form action="{{ route('administratives.destroy', $administrative) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" onclick="return confirm('¿Estás seguro de que deseas eliminar este administrativo?')">Eliminar</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
</body>
</html>