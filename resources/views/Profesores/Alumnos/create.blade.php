<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Estudiante</title>
</head>
<body>
    <h1>Registrar Estudiante</h1>

    <form action="{{ route('students.store') }}" method="POST">
        @csrf

        <label for="enrollment">Matrícula:</label>
        <input type="text" name="enrollment" id="enrollment" required><br>

        <label for="last_name_father">Apellido Paterno:</label>
        <input type="text" name="last_name_father" id="last_name_father" required><br>

        <label for="last_name_mother">Apellido Materno:</label>
        <input type="text" name="last_name_mother" id="last_name_mother" required><br>

        <label for="first_name">Nombre:</label>
        <input type="text" name="first_name" id="first_name" required><br>

        <label for="semester">Semestre:</label>
        <input type="number" name="semester" id="semester" required><br>

        <label for="career_id">Carrera:</label>
        <select name="career_id" id="career_id" required>
            @foreach($careers as $career)
                <option value="{{ $career->id }}">{{ $career->name }}</option>
            @endforeach
        </select><br>

        <label for="gender">Género:</label>
        <input type="text" name="gender" id="gender" required><br>

        <label for="age">Edad:</label>
        <input type="number" name="age" id="age" required><br>

        <label for="teacher_id">Asesor:</label>
        <select name="teacher_id" id="teacher_id">
            <option value="">-- Ninguno --</option>
            @foreach($teachers as $teacher)
                <option value="{{ $teacher->id }}">{{ $teacher->first_name }}</option>
            @endforeach
        </select><br>

        <button type="submit">Guardar</button>
    </form>
</body>
</html>
