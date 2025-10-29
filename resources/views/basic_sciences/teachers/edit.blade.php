<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Maestro</title>
</head>
<body>
    <h1>Editar Maestro</h1>

    <form action="{{ route('basic_sciences.teachers.update', $teacher) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Usuario:</label>
        <input type="text" name="teacher_user" value="{{ $teacher->teacher_user }}" required><br><br>

        <label>Nombre(s):</label>
        <input type="text" name="name" value="{{ $teacher->name }}" required><br><br>

        <label>Apellido Paterno:</label>
        <input type="text" name="last_name_f" value="{{ $teacher->last_name_f }}" required><br><br>

        <label>Apellido Materno:</label>
        <input type="text" name="last_name_m" value="{{ $teacher->last_name_m }}" required><br><br>

        <label>Grado de Estudios:</label>
        <input type="text" name="degree" value="{{ $teacher->degree }}" required><br><br>

        <label>¿Es Tutor?</label>
        <select name="tutor">
            <option value="0" {{ !$teacher->tutor ? 'selected' : '' }}>No</option>
            <option value="1" {{ $teacher->tutor ? 'selected' : '' }}>Sí</option>
        </select><br><br>

        <label>¿Tiene horas de ciencias basicas?:</label>
        <select name="science_department">
            <option value="0" {{ !$teacher->science_department ? 'selected' : '' }}>No</option>
            <option value="1" {{ $teacher->science_department ? 'selected' : '' }}>Sí</option>
        </select><br><br>

        <label>Carrera:</label>
        <select name="career_id" required>
            @foreach ($careers as $career)
                <option value="{{ $career->id }}" {{ $teacher->career_id == $career->id ? 'selected' : '' }}>
                    {{ $career->name }}
                </option>
            @endforeach
        </select><br><br>

        <button type="submit">Actualizar</button>
    </form>
</body>
</html>
