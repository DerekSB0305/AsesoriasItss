<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inicio ciencias basicas</title>
</head>
<body>
    <h1>Bienvenido</h1>
    <a href="{{ route('basic_sciences.administratives.index') }}">Gestionar Administrativos</a>
    <a href="{{ route('basic_sciences.teachers.index') }}">Gestionar Maestros</a>
    <a href="{{ route('basic_sciences.students.index') }}">ver Estudiantes</a>
    <a href="{{ route ('basic_sciences.requests.index') }}">Ver Solicitudes</a>
    <a href="{{ route ('basic_sciences.advisories.index') }}">Gestionar asesorias</a>
    <a href="{{ route ('basic_sciences.users.index') }}">Ver Usuarios</a>
    
</body>
</html>