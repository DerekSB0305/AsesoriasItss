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

        <label>Usuario:</label>
        <input type="text" name="teacher_user" required><br><br>

        <label>Nombre(s):</label>
        <input type="text" name="name" required><br><br>

        <label>Apellido Paterno:</label>
        <input type="text" name="last_name_f" required><br><br>

        <label>Apellido Materno:</label>
        <input type="text" name="last_name_m" required><br><br>

        <label>Grado de Estudios:</label>
        <input type="text" name="degree" required><br><br>

        <label>¿Es Tutor?</label>
        <select name="tutor">
            <option value="0">No</option>
            <option value="1">Sí</option>
        </select><br><br>

        <label>¿Tiene horas de ciencias basicas?:</label>
        <select name="science_department">
            <option value="0">No</option>
            <option value="1">Sí</option>
        </select><br><br>

       <label for="career_id">Carrera:</label>
        <select name="career_id" id="career_id" required>
            <option value="">Selecciona una carrera</option>
             @foreach ($careers as $career)
             <option value="{{ $career->career_id }}">{{ $career->name }}</option>
            @endforeach
        </select><br><br>

        <button type="submit">Guardar</button>
    </form>
</body>
</html>
