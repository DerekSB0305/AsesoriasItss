<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel Jefatura de Carrera</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <x-career-head-navbar />

    @if($passwordIgual)
    <div class="w-[95%] max-w-3xl mx-auto mt-6 text-center">
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-800 p-4 rounded-xl shadow">

            <p class="font-semibold text-lg mb-1">⚠ Atención</p>
            <p class="text-sm sm:text-base">Tu contraseña actual coincide con tu usuario. Cámbiala por seguridad.</p>

            <a href="{{ route('career_head.change_password') }}"
               class="inline-block mt-3 px-5 py-2 bg-[#28A745] text-white rounded-lg font-semibold hover:bg-green-700 transition">
                Cambiar contraseña
            </a>
        </div>
    </div>
    @endif

    <main class="flex-1 px-4 sm:px-6 lg:px-10 py-10">

        <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-800 text-center mb-10">
            Panel de Jefatura de Carrera
        </h1>

        <div class="grid 
                    grid-cols-1 
                    sm:grid-cols-2 
                    lg:grid-cols-3 
                    gap-6 sm:gap-8">

            <a href="{{ route('career_head.teachers.index') }}"
               class="bg-white shadow-lg rounded-xl p-6 hover:shadow-2xl transition-all transform hover:-translate-y-1 text-center">
                <span class="material-icons text-blue-600 text-6xl sm:text-7xl mb-3">school</span>
                <h2 class="font-bold text-base sm:text-lg text-gray-700">👨‍🏫 Ver Maestros</h2>
            </a>

            <a href="{{ route('career_head.students.index') }}"
               class="bg-white shadow-lg rounded-xl p-6 hover:shadow-2xl transition-all transform hover:-translate-y-1 text-center">
                <span class="material-icons text-green-600 text-6xl sm:text-7xl mb-3">groups</span>
                <h2 class="font-bold text-base sm:text-lg text-gray-700">🎓 Ver Alumnos</h2>
            </a>

            <a href="{{ route('career_head.advisories.index') }}"
               class="bg-white shadow-lg rounded-xl p-6 hover:shadow-2xl transition-all transform hover:-translate-y-1 text-center">
                <span class="material-icons text-purple-600 text-6xl sm:text-7xl mb-3">event_note</span>
                <h2 class="font-bold text-base sm:text-lg text-gray-700">🧩 Ver Asesorías</h2>
            </a>

            <a href="{{ route('career_head.manuals.index') }}"
               class="bg-white shadow-lg rounded-xl p-6 hover:shadow-2xl transition-all transform hover:-translate-y-1 text-center">
                <span class="material-icons text-yellow-600 text-6xl sm:text-7xl mb-3">menu_book</span>
                <h2 class="font-bold text-base sm:text-lg text-gray-700">📘 Ver Manuales</h2>
            </a>

        </div>

    </main>

    <x-basic-sciences-footer />

    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</body>
</html>
