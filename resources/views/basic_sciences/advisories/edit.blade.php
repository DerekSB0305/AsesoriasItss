<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Asesoría</title>
</head>
<body>

<h1>Editar Asesoría</h1>

<form action="{{ route('basic_sciences.advisories.update', $advisory->advisory_id) }}"
      method="POST" enctype="multipart/form-data">
    @csrf
    @method('PUT')

    <h3>Información general</h3>

    <p><strong>Maestro:</strong> 
        {{ $advisory->teacherSubject->teacher->name }} 
        {{ $advisory->teacherSubject->teacher->last_name_f }}
    </p>

    <p><strong>Materia:</strong> {{ $advisory->teacherSubject->subject->name }}</p>
    <p><strong>Carrera:</strong> {{ $advisory->teacherSubject->career->name }}</p>

    <br>

    <label>Fecha y hora:</label>
    <input type="datetime-local" name="schedule"
           value="{{ date('Y-m-d\TH:i', strtotime($advisory->schedule)) }}">
    <br><br>

    <label>Salón:</label>
    <input type="text" name="classroom" value="{{ $advisory->classroom }}">
    <br><br>

    <label>Edificio:</label>
    <input type="text" name="building" value="{{ $advisory->building }}">
    <br><br>

    <label>Archivo (opcional):</label>
    <input type="file" name="assignment_file">
    <br><br>

    <h3>Alumnos inscritos</h3>

    <h3>Seleccionar alumnos:</h3>

<select name="students[]" multiple size="8" required>
    @foreach ($students as $stu)
        <option value="{{ $stu['enrollment'] }}"
            {{ in_array($stu['enrollment'], $currentStudents) ? 'selected' : '' }}>
            {{ $stu['enrollment'] }} - {{ $stu['name'] }}
        </option>
    @endforeach
</select>

<p class="text-xs text-gray-500 mt-1">
    * CTRL + clic para seleccionar varios
</p>

    <br><br>

    <button type="submit">Guardar cambios</button>

</form>

<br>
<a href="{{ route('basic_sciences.advisories.index') }}">Volver</a>

</body>
</html>
