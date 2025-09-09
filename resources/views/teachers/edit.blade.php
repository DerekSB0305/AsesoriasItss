<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Maestro</title>
</head>
<body>
    <h1>Editar Maestro</h1>

    <form action="{{ route('teachers.update', $teacher) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Nombre(s):</label>
        <input type="text" name="first_name" value="{{ $teacher->first_name }}" required><br><br>

        <label>Apellido Paterno:</label>
        <input type="text" name="last_name_father" value="{{ $teacher->last_name_father }}" required><br><br>

        <label>Apellido Materno:</label>
        <input type="text" name="last_name_mother" value="{{ $teacher->last_name_mother }}" required><br><br>

        <label>Grado de Estudios:</label>
        <input type="text" name="study_degree" value="{{ $teacher->study_degree }}" required><br><br>

        <label>¿Es Tutor?</label>
        <select name="tutor">
            <option value="0" {{ !$teacher->tutor ? 'selected' : '' }}>No</option>
            <option value="1" {{ $teacher->tutor ? 'selected' : '' }}>Sí</option>
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
