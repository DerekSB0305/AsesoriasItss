<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Inicio ciencias basicas</title>
</head>
<body>

<br>
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit">Cerrar sesión</button>
    </form>
</br>

    <h1>Bienvenido</h1>
    <a href="{{ route('basic_sciences.administratives.index') }}">Gestionar Administrativos</a><br>
    <a href="{{ route('basic_sciences.teachers.index') }}">Crear Maestros</a><br>
    <a href="{{ route ('basic_sciences.teacher_subjects.index') }}">Asignar Materias a Maestros</a><br>
    <a href="{{ route('basic_sciences.students.index') }}">ver Estudiantes</a><br>
    <a href="{{ route ('basic_sciences.requests.index') }}">Ver Solicitudes</a><br>
    <a href="{{ route ('basic_sciences.advisories.index') }}">Gestionar asesorias</a>
    <a href="{{ route ('basic_sciences.users.index') }}">Ver Usuarios</a>
    
</body>
</html>