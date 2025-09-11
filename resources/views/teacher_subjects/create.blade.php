<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Nueva Asignación</title>
</head>
<body>
    <h1>Asignar Materia a Maestro</h1>

    <form action="{{ route('teacher_subjects.store') }}" method="POST">
        @csrf

        <label>Maestro:</label>
        <select name="teacher_id" required>
            <option value="">-- Selecciona un maestro --</option>
            @foreach($teachers as $teacher)
                <option value="{{ $teacher->id }}">{{ $teacher->first_name }}</option>
            @endforeach
        </select>
        <br><br>

        <label>Materia:</label>
        <select name="subject_id" required>
            <option value="">-- Selecciona una materia --</option>
            @foreach($subjects as $subject)
                <option value="{{ $subject->id }}">{{ $subject->name }}</option>
            @endforeach
        </select>
        <br><br>

        <label>Carrera:</label>
        <select name="career_id" required>
            <option value="">-- Selecciona una carrera --</option>
            @foreach($careers as $career)
                <option value="{{ $career->id }}">{{ $career->name }}</option>
            @endforeach
        </select>
        <br><br>

        <button type="submit">Guardar</button>
    </form>

    <br>
    <a href="{{ route('teacher_subjects.index') }}">⬅ Volver a la lista</a>
</body>
</html>
