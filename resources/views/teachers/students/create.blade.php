<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Alumno</title>
</head>
<body>

<h2>Registrar Alumno</h2>

@if ($errors->any())
    <div style="color:red;">
        <ul>
            @foreach ($errors->all() as $item)
                <li>{{ $item }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('teachers.students.store') }}">
    @csrf

    <label>Matrícula: </label>
    <input type="text" name="enrollment" value="{{ old('enrollment') }}" required><br><br>

    <label>Apellido Paterno: </label>
    <input type="text" name="last_name_f" value="{{ old('last_name_f') }}" required><br><br>

    <label>Apellido Materno: </label>
    <input type="text" name="last_name_m" value="{{ old('last_name_m') }}" required><br><br>

    <label>Nombre: </label>
    <input type="text" name="name" value="{{ old('name') }}" required><br><br>

    <label>Semestre: </label>
    <input type="number" name="semester" value="{{ old('semester') }}" required><br><br>

    <label>Grupo: </label>
    <input type="text" name="group" value="{{ old('group') }}" required><br><br>

    <label>Género: </label>
    <select name="gender" required>
        <option value="">Seleccione uno</option>
        <option value="Masculino" {{ old('gender')=='Masculino' ? 'selected':'' }}>Masculino</option>
        <option value="Femenino" {{ old('gender')=='Femenino' ? 'selected':'' }}>Femenino</option>
    </select><br><br>

    <label>Edad: </label>
    <input type="number" name="age" value="{{ old('age') }}" required><br><br>

    <label>Carrera: </label>
    <select name="career_id" required>
        <option value="">Seleccione...</option>
        @foreach ($careers as $career)
            <option value="{{ $career->career_id }}" {{ old('career_id') == $career->career_id ? 'selected':'' }}>
                {{ $career->career_name ?? $career->name ?? $career->career }}
            </option>
        @endforeach
    </select><br><br>

    <button type="submit">Guardar Alumno</button>
</form>

<br>
<a href="{{ route('teachers.students.index') }}">Volver</a>

</body>
</html>
