<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Editar Administrativo</title>
</head>
<body>
    <h1>Editar Administrativo</h1>
  @if ($errors->any())
    <div style="background:#ffe1e1; color:#b40000; padding:10px; border-radius:6px; margin-bottom:15px;">
        <strong>Hay errores en el formulario:</strong>
        <ul style="margin-left:20px;">
            @foreach ($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ route('basic_sciences.administratives.update', $administrative) }}" method="POST">
    @csrf
    @method('PUT')

    {{-- Campo oculto --}}
    <input type="hidden" name="administrative_user" value="{{ $administrative->administrative_user }}">

    <label>Nombre:</label>
    <input type="text" 
           name="name" 
           value="{{ old('name', $administrative->name) }}" required>

    <label>Apellido paterno:</label>
    <input type="text" 
           name="last_name_f" 
           value="{{ old('last_name_f', $administrative->last_name_f) }}" required>

    <label>Apellido materno:</label>
    <input type="text" 
           name="last_name_m" 
           value="{{ old('last_name_m', $administrative->last_name_m) }}" required>

    <label>Puesto:</label>
    <input type="text" 
           name="position" 
           value="{{ old('position', $administrative->position) }}" required>

    <label>Carrera (opcional):</label>
    <select name="career_id">
        <option value="">Sin carrera</option>

        @foreach($careers as $c)
            <option value="{{ $c->career_id }}" 
                {{ $c->career_id == $administrative->career_id ? 'selected' : '' }}>
                {{ $c->name }}
            </option>
        @endforeach
    </select>

    <button type="submit">Actualizar</button>
</form>



</body>
</html>