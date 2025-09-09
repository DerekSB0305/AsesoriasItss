<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editar Departamento</title>
</head>
<body>
    <h1>Editar departamento</h1>
    <form action="{{ route('departments.update', $department) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="name">Nombre:</label>
            <input type="text" id="name" name="name" value="{{ $department->name }}" required>
            @error ("name") <p style="color: red;">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="type">Tipo:</label>
            <input type="text" id="type" name="type" value="{{ $department->type }}" required>
            @error ("type") <p style="color: red;">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="location">Ubicación:</label>
            <input type="text" id="location" name="location" value="{{ $department->location }}" required>
            @error ("location") <p style="color: red;">{{ $message }}</p> @enderror
        </div>
        <button type="submit">Actualizar</button>
</body>
</html>