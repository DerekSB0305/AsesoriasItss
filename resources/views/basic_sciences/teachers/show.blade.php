<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalle del Maestro</title>
</head>
<body>
    <h1>Detalle del Maestro</h1>

    <p><strong>ID:</strong> {{ $teacher->id }}</p>
    <p><strong>Nombre:</strong> {{ $teacher->first_name }}</p>
    <p><strong>Apellido Paterno:</strong> {{ $teacher->last_name_father }}</p>
    <p><strong>Apellido Materno:</strong> {{ $teacher->last_name_mother }}</p>
    <p><strong>Grado de Estudios:</strong> {{ $teacher->study_degree }}</p>
    <p><strong>Tutor:</strong> {{ $teacher->tutor ? 'Sí' : 'No' }}</p>
    <p><strong>Carrera:</strong> {{ $teacher->career->name ?? 'Sin carrera' }}</p>

    <a href="{{ route('basic_sciences.teachers.index') }}">Volver a la lista</a>
</body>
</html>
