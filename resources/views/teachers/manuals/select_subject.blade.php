<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Seleccionar Materia</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
    <x-teachers-navbar/>

     <div class="flex-grow p-6">

    <div class="max-w-4xl mx-auto bg-white p-8 rounded-xl shadow-lg">

        {{-- Regresar --}}
        <a href="{{ route('teachers.manuals.index') }}"
           class="text-indigo-600 hover:text-indigo-800 font-medium">
            ← Volver a Manuales
        </a>

        {{-- Título --}}
        <h1 class="text-3xl font-bold text-gray-800 mt-4 mb-6">
            📘 Seleccionar materia
        </h1>

        <p class="text-gray-600 mb-6">
            Selecciona la materia para subir un nuevo manual.
        </p>

        {{-- Materias --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            @forelse ($subjects as $sub)

                <a href="{{ route('teachers.manuals.create', $sub->teacher_subject_id) }}"
                    class="p-5 bg-indigo-50 rounded-lg shadow hover:bg-indigo-100 transition block">

                    <h2 class="text-xl font-semibold text-indigo-700 mb-1">
                        {{ $sub->subject->name }}
                    </h2>

                    <p class="text-gray-600 text-sm">
                        Carrera: {{ $sub->subject->career->name }}
                    </p>
                </a>

            @empty
                <p class="text-gray-600">No tienes materias asignadas.</p>
            @endforelse

        </div>

    </div>
    </div>

    <x-basic-sciences-footer />

</body>

</html>
