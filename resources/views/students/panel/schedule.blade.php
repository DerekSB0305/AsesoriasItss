<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mi horario</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col items-center justify-center">
    <x-students-navbar/>
     <div class="flex-grow p-6">

    <div class="max-w-3xl w-full bg-white p-8 rounded-xl shadow-lg">

        <a href="{{ route('students.panel.index') }}"
           class="text-indigo-600 hover:text-indigo-800 text-sm">
            ← Regresar al panel
        </a>

        <h1 class="text-3xl font-bold text-gray-800 mt-4 mb-6">
            📅 Mi Horario
        </h1>

        @if ($student->schedule_file)
            <p class="text-gray-700 mb-4">
                Puedes ver o descargar tu horario aquí:
            </p>

            <a href="{{ asset('storage/' . $student->schedule_file) }}"
               target="_blank"
               class="px-4 py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                Ver / Descargar horario
            </a>

        @else
            <p class="text-gray-500 text-lg">
                Todavía no se ha subido un horario para ti.
            </p>
        @endif

    </div>
    </div>
    <x-basic-sciences-footer />
</body>
</html>
