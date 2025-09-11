<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Materia</title>
</head>
<body>
    <h1>Registrar Materia</h1>

    <form action="{{ route('subjects.store') }}" method="POST">
        @csrf

        <label for="name">Nombre:</label>
        <input type="text" name="name" id="name" required><br>

        <label for="credits">Créditos:</label>
        <input type="number" name="credits" id="credits" required><br>

        <label for="career_id">Carrera:</label>
        <select name="career_id" id="career_id" required>
            @foreach($careers as $career)
                <option value="{{ $career->id }}">{{ $career->name }}</option>
            @endforeach
        </select><br>

        <button type="submit">Guardar</button>
    </form>
</body>
</html>
