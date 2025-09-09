<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Crear Departamento</title>
</head>
<body>
    <h1>Crear Departamento</h1>
    <form action="{{ route('departments.store') }}" method="POST">
        @csrf
        <div>
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" required>
        </div>
        <div>
            <label for="type">Tipo:</label>
            <input type="text" id="type" name="type" required>
        </div>
        <div>
            <label for="location">Ubicación:</label>
            <input type="text" id="location" name="location" required>
        </div>
        <button type="submit">Crear</button>
    </form>
</body>
</html>
