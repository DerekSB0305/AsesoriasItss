<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Alumno</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 p-8">

<div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-6">

    <h1 class="text-2xl font-bold mb-4">Editar Alumno</h1>

    @if ($errors->any())
        <div class="bg-red-100 text-red-800 border border-red-300 rounded-md p-3 mb-4">
            <strong>Hay errores en el formulario:</strong>
            <ul class="mt-2 ml-4 list-disc">
                @foreach ($errors->all() as $e)
                    <li>{{ $e }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('teachers.students.update', $student->enrollment) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Matrícula (solo lectura) --}}
        <label class="font-medium">Matrícula:</label>
        <input type="text" value="{{ $student->enrollment }}"
               class="w-full border rounded p-2 bg-gray-200" readonly>

        <label class="font-medium mt-3">Nombre:</label>
        <input type="text" name="name" value="{{ $student->name }}"
               class="w-full border rounded p-2" required>

        <label class="font-medium mt-3">Apellido paterno:</label>
        <input type="text" name="last_name_f" value="{{ $student->last_name_f }}"
               class="w-full border rounded p-2" required>

        <label class="font-medium mt-3">Apellido materno:</label>
        <input type="text" name="last_name_m" value="{{ $student->last_name_m }}"
               class="w-full border rounded p-2">

        <label class="font-medium mt-3">Semestre:</label>
        <input type="number" name="semester" value="{{ $student->semester }}"
               class="w-full border rounded p-2" required>

        <label class="font-medium mt-3">Grupo:</label>
        <input type="text" name="group" value="{{ $student->group }}"
               class="w-full border rounded p-2" required>

        <label class="font-medium mt-3">Género:</label>
        <select name="gender" class="w-full border rounded p-2">
            <option {{ $student->gender == 'Masculino' ? 'selected' : '' }}>Masculino</option>
            <option {{ $student->gender == 'Femenino' ? 'selected' : '' }}>Femenino</option>
            <option {{ $student->gender == 'Otro' ? 'selected' : '' }}>Otro</option>
        </select>

        <label class="font-medium mt-3">Edad:</label>
        <input type="number" name="age" value="{{ $student->age }}"
               class="w-full border rounded p-2" required>

        <label class="font-medium mt-3">Carrera:</label>
        <select name="career_id" class="w-full border rounded p-2" required>
            @foreach ($careers as $c)
                <option value="{{ $c->career_id }}"
                        {{ $c->career_id == $student->career_id ? 'selected' : '' }}>
                    {{ $c->name }}
                </option>
            @endforeach
        </select>

        <button type="submit"
                class="mt-4 bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
            Guardar Cambios
        </button>

    </form>

    <a href="{{ route('teachers.students.index') }}"
       class="block mt-4 text-blue-600">
       ← Volver al listado
    </a>

</div>

</body>

</html>
