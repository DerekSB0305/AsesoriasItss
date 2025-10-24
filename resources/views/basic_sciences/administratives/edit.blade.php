<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editar Administrativo</title>
</head>
<body>
    <h1>Editar Administrativo</h1>
    <form action="{{ route('basic_sciences.administratives.update', $administrative) }}" method="POST">
        @csrf
        @method('PUT')
        <div>
            <label for="first_name">Nombre:</label>
            <input type="text" id="first_name" name="first_name" value="{{ old('first_name', $administrative->first_name) }}" required>
            @error ("first_name") <p style="color: red;">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="last_name_father">Apellido Paterno:</label>
            <input type="text" id="last_name_father" name="last_name_father" value="{{ old('last_name_father', $administrative->last_name_father) }}" required>
            @error ("last_name_father") <p style="color: red;">{{ $message }}</p> @enderror
        </div>
        <div>
            <label for="last_name_mother">Apellido Materno:</label>
            <input type="text" id="last_name_mother" name="last_name_mother" value="{{ old('last_name_mother', $administrative->last_name_mother) }}" required>
            @error ("last_name_mother") <p style="color: red;">{{ $message }}</p> @enderror
        <div>
        <div>
            <label for="position">Puesto:</label>
            <input type="text" id="position" name="position" value="{{ old('position', $administrative->position) }}" required>
            @error ("position") <p style="color: red;">{{ $message }}</p> @enderror
        </div>
        
        <button type="submit">Actualizar</button>
</body>
</html>