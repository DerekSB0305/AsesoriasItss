<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agregar Maestro</title>
</head>
<body>
    <h1>Agregar Maestro</h1>

    <form action="{{ route('basic_sciences.teachers.store') }}" method="POST">
        @csrf
        <label>Nombre(s):</label>
        <input type="text" name="first_name" required><br><br>

        <label>Apellido Paterno:</label>
        <input type="text" name="last_name_father" required><br><br>

        <label>Apellido Materno:</label>
        <input type="text" name="last_name_mother" required><br><br>

        <label>Grado de Estudios:</label>
        <input type="text" name="study_degree" required><br><br>

        <label>¿Es Tutor?</label>
        <select name="tutor">
            <option value="0">No</option>
            <option value="1">Sí</option>
        </select><br><br>

        <label>Carrera:</label>
        <select name="career_id" required>
            @foreach ($careers as $career)
                <option value="{{ $career->id }}">{{ $career->name }}</option>
            @endforeach
        </select><br><br>

        <button type="submit">Guardar</button>
    </form>
</body>
</html>
