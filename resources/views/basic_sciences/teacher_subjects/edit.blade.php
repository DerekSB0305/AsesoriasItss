<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar asignación</title>
</head>
<body>

<h1>Editar Asignación</h1>

<form action="{{ route('basic_sciences.teacher_subjects.update', $teacherSubject->teacher_subject_id) }}" method="POST">
    @csrf
    @method('PUT')

    {{-- maestro --}}
    <label>Maestro:</label>
    <select name="teacher_user" disabled>
        <option value="{{ $teacherSubject->teacher_user }}">
            {{ $teacherSubject->teacher->name }} {{ $teacherSubject->teacher->last_name_f }} {{ $teacherSubject->teacher->last_name_m }}
        </option>
    </select>
    <br><br>

    {{-- materias --}}
<select name="subject_id">
    @foreach($subjects as $subject)
        <option value="{{ $subject->subject_id }}"
            {{ $subject->subject_id == $teacherSubject->subject_id ? 'selected' : '' }}>
            {{ $subject->name }}
        </option>
    @endforeach
</select>
    <br><br>

    {{-- carrera --}}
    <label>Carrera:</label>
    <select name="career_id">
        @foreach($careers as $career)
            <option value="{{ $career->career_id }}"
                {{ $career->career_id == $teacherSubject->career_id ? 'selected' : '' }}>
                {{ $career->name }}
            </option>
        @endforeach
    </select>
    <br><br>

    <button type="submit">Actualizar</button>
</form>

<br>
<a href="{{ route('basic_sciences.teacher_subjects.index') }}">Volver</a>

</body>
</html>


