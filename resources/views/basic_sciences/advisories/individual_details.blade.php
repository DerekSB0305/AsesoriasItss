<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles de Asesoría</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen p-8">

<div class="max-w-4xl mx-auto bg-white shadow-lg rounded-xl p-6">

    <h1 class="text-2xl font-bold mb-4 text-gray-800">
        Detalles de Asesoría #{{ $advisory->advisory_id }}
    </h1>

    {{-- Información general --}}
    <div class="grid grid-cols-2 gap-4 text-gray-700 mb-6">

        <div>
            <p><strong>Maestro:</strong><br>
                {{ $advisory->teacherSubject->teacher->name }}
                {{ $advisory->teacherSubject->teacher->last_name_f }}
                {{ $advisory->teacherSubject->teacher->last_name_m }}
            </p>
        </div>

        <div>
            <p><strong>Materia:</strong><br>
                {{ $advisory->teacherSubject->subject->name }}</p>
        </div>

        <div>
            <p><strong>Carrera de la materia:</strong><br>
                {{ $advisory->teacherSubject->subject->career->name }}</p>
        </div>

        <div>
            <p><strong>Fecha / Hora:</strong><br>
                {{ $advisory->schedule }}</p>
        </div>

        <div>
            <p><strong>Aula:</strong><br>
                {{ $advisory->classroom ?? 'N/A' }}</p>
        </div>

        <div>
            <p><strong>Edificio:</strong><br>
                {{ $advisory->building ?? 'N/A' }}</p>
        </div>

        <div>
            <p><strong>Estado:</strong><br>
                {{ $advisory->advisoryDetail->status }}</p>
        </div>

        <div>
            <p><strong>Ficha de canalización:</strong><br>
                @if($advisory->assignment_file)
                    <a href="{{ asset('storage/'.$advisory->assignment_file) }}"
                       class="text-blue-600 underline" target="_blank">
                        Ver archivo
                    </a>
                @else
                    No disponible
                @endif
            </p>
        </div>

    </div>

    {{-- Resumen de alumnos --}}
    <h2 class="text-xl font-semibold mb-3 text-gray-800">Resumen de alumnos</h2>

    <div class="flex gap-6 mb-6">
        <p><strong>Total:</strong> {{ $total }}</p>
        <p class="text-blue-600"><strong>Hombres:</strong> {{ $hombres }}</p>
        <p class="text-pink-600"><strong>Mujeres:</strong> {{ $mujeres }}</p>
    </div>

    {{-- Lista de alumnos --}}
    <h2 class="text-xl font-semibold mb-3 text-gray-800">Lista de alumnos</h2>

    <table class="w-full border text-sm">
        <thead class="bg-gray-100">
            <tr>
                <th class="border px-3 py-2">Matrícula</th>
                <th class="border px-3 py-2">Nombre</th>
                <th class="border px-3 py-2">Género</th>
                <th class="border px-3 py-2">Carrera</th>
            </tr>
        </thead>

        <tbody>
        @foreach($students as $stu)
            <tr>
                <td class="border px-3 py-2">{{ $stu->enrollment }}</td>
                <td class="border px-3 py-2">{{ $stu->name }} {{ $stu->last_name_f }} {{ $stu->last_name_m }}</td>
                <td class="border px-3 py-2">{{ $stu->gender }}</td>
                <td class="border px-3 py-2">{{ $stu->career->name }}</td>
            </tr>
        @endforeach
        </tbody>
    </table>

    <div class="mt-6">
        <a href="{{ route('basic_sciences.advisories.index') }}"
           class="text-green-700 hover:text-green-900 font-medium">
            ← Volver
        </a>
    </div>

</div>

</body>
</html>
