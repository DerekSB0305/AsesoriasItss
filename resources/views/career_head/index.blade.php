<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Jefatura de Carrera</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen">

    {{-- NAVBAR --}}
    <x-basic-sciences-navbar />

    <div class="p-10">

        <h1 class="text-3xl font-extrabold text-gray-800 mb-8 text-center">
            Panel de Jefatura de Carrera
        </h1>

        {{-- GRID DE CARDS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

            {{-- MAESTROS --}}
            <a href="{{ route('career_head.teachers.index') }}"
            class="bg-white shadow-lg rounded-xl p-4 hover:shadow-2xl transition transform hover:-translate-y-1">
                <span class="material-icons text-blue-600 text-7xl w-full text-center mb-4">school</span>
                <h2 class="text-center font-bold text-lg text-gray-700">👨‍🏫 Ver Maestros</h2>
            </a>

            {{-- ALUMNOS --}}
            <a href="{{ route('career_head.students.index') }}"
            class="bg-white shadow-lg rounded-xl p-4 hover:shadow-2xl transition transform hover:-translate-y-1">
                <span class="material-icons text-green-600 text-7xl w-full text-center mb-4">groups</span>
                <h2 class="text-center font-bold text-lg text-gray-700">🎓 Ver Alumnos</h2>
            </a>

            {{-- ASESORÍAS --}}
            <a href="{{ route('career_head.advisories.index') }}"
            class="bg-white shadow-lg rounded-xl p-4 hover:shadow-2xl transition transform hover:-translate-y-1">
                <span class="material-icons text-purple-600 text-7xl w-full text-center mb-4">event_note</span>
                <h2 class="text-center font-bold text-lg text-gray-700">🧩 Ver Asesorías</h2>
            </a>

            {{-- MANUALES --}}
            <a href="{{ route('career_head.manuals.index') }}"
            class="bg-white shadow-lg rounded-xl p-4 hover:shadow-2xl transition transform hover:-translate-y-1">
                <span class="material-icons text-yellow-600 text-7xl w-full text-center mb-4">menu_book</span>
                <h2 class="text-center font-bold text-lg text-gray-700">📘 Ver Manuales</h2>
            </a>

        </div>

    </div>

    {{-- FOOTER --}}
    <x-basic-sciences-footer />

    {{-- GOOGLE ICONS --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</body>
</html>
