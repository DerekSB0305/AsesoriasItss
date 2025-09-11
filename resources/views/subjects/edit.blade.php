<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Materia</title>
</head>
<body>
    <h1>Editar Materia</h1>

    <form action="{{ route('subjects.update', $subject) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="name">Nombre:</label>
        <input type="text" name="name" id="name" value="{{ $subject->name }}" required><br>

        <label for="credits">Créditos:</label>
        <input type="number" name="credits" id="credits" value="{{ $subject->credits }}" required><br>

        <label for="career_id">Carrera:</label>
        <select name="career_id" id="career_id" required>
            @foreach($careers as $career)
                <option value="{{ $career->id }}" @if($subject->career_id == $career->id) selected @endif>
                    {{ $career->name }}
                </option>
            @endforeach
        </select><br>

        <button type="submit">Actualizar</button>
    </form>
</body>
</html>
