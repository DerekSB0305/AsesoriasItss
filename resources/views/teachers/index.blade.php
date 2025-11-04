<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel del Maestro</title>
</head>
<body>

    <h1>Bienvenido Maestro</h1>

    <h3>Acciones:</h3>
    <ul>
        <li><a href="{{ route('teachers.students.index') }}">📘 Ver alumnos registrados</a></li>
        <li><a href="{{ route('teachers.students.create') }}">➕ Registrar alumno</a></li>
        <li><a href="{{ route('teachers.requests.index') }}">📄 Ver solicitudes de asesoría</a></li>
        <li><a href="{{ route('teachers.requests.create') }}">➕ Solicitar asesoría</a></li>
    </ul>

    <br><br>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Cerrar sesión</button>
    </form>

</body>
</html>
