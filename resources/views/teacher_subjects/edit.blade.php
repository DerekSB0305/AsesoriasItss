<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Editar Asignación</title>
</head>
<body>
    <h1>Editar Asignación</h1>

    <form action="{{ route('teacher_subjects.update', $teacherSubject) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Maestro:</label>
        <select name="teacher_id" required>
            @foreach($teachers as $teacher)
                <option value="{{ $teacher->id }}" 
                    {{ $teacherSubject->teacher_id == $teacher->id ? 'selected' : '' }}>
                    {{ $teacher->first_name }}
                </option>
            @endforeach
        </select>
        <br><br>

        <label>Materia:</label>
        <select name="subject_id" required>
            @foreach($subjects as $subject)
                <option value="{{ $subject->id }}" 
                    {{ $teacherSubject->subject_id == $subject->id ? 'selected' : '' }}>
                    {{ $subject->name }}
                </option>
            @endforeach
        </select>
        <br><br>

        <label>Carrera:</label>
        <select name="career_id" required>
            @foreach($careers as $career)
                <option value="{{ $career->id }}" 
                    {{ $teacherSubject->career_id == $career->id ? 'selected' : '' }}>
                    {{ $career->name }}
                </option>
            @endforeach
        </select>
        <br><br>

        <button type="submit">Actualizar</button>
    </form>

    <br>
    <a href="{{ route('teacher_subjects.index') }}">⬅ Volver a la lista</a>
</body>
</html>
