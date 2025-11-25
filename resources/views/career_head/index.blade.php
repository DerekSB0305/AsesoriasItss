<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel Jefatura de Carrera</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- NAVBAR --}}
    <x-career-head-navbar />

    {{-- AVISO CONTRASEÑA --}}
    @if($passwordIgual)
    <div class="mx-auto w-full max-w-3xl mt-6 text-center">
        <div class="bg-yellow-100 border border-yellow-400 text-yellow-800 p-4 rounded-lg shadow text-center">

            <p class="font-semibold text-lg mb-2">⚠ Atención</p>
            <p>Tu contraseña actual es igual a tu usuario. Por seguridad, te recomendamos cambiarla.</p>

            <a href="{{ route('career_head.change_password') }}"
               class="inline-block mt-3 px-5 py-2 bg-[#28A745] text-white rounded-lg font-semibold hover:bg-green-700 transition">
                Cambiar contraseña
            </a>
        </div>
    </div>
    @endif

    {{-- CONTENIDO PRINCIPAL --}}
    <div class="p-10 flex-1">

        <h1 class="text-3xl font-extrabold text-gray-800 mb-8 text-center">
            Panel de Jefatura de Carrera
        </h1>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

            {{-- MAESTROS --}}
            <a href="{{ route('career_head.teachers.index') }}"
            class="bg-white shadow-lg rounded-xl p-6 hover:shadow-2xl transition transform hover:-translate-y-1 text-center">
                <span class="material-icons text-blue-600 text-7xl mb-4">school</span>
                <h2 class="font-bold text-lg text-gray-700">👨‍🏫 Ver Maestros</h2>
            </a>

            {{-- ALUMNOS --}}
            <a href="{{ route('career_head.students.index') }}"
            class="bg-white shadow-lg rounded-xl p-6 hover:shadow-2xl transition transform hover:-translate-y-1 text-center">
                <span class="material-icons text-green-600 text-7xl mb-4">groups</span>
                <h2 class="font-bold text-lg text-gray-700">🎓 Ver Alumnos</h2>
            </a>

            {{-- ASESORÍAS --}}
            <a href="{{ route('career_head.advisories.index') }}"
            class="bg-white shadow-lg rounded-xl p-6 hover:shadow-2xl transition transform hover:-translate-y-1 text-center">
                <span class="material-icons text-purple-600 text-7xl mb-4">event_note</span>
                <h2 class="font-bold text-lg text-gray-700">🧩 Ver Asesorías</h2>
            </a>

            {{-- MANUALES --}}
            <a href="{{ route('career_head.manuals.index') }}"
            class="bg-white shadow-lg rounded-xl p-6 hover:shadow-2xl transition transform hover:-translate-y-1 text-center">
                <span class="material-icons text-yellow-600 text-7xl mb-4">menu_book</span>
                <h2 class="font-bold text-lg text-gray-700">📘 Ver Manuales</h2>
            </a>

        </div>

    </div>

    {{-- FOOTER pegado al fondo --}}
    <x-basic-sciences-footer />

    {{-- GOOGLE ICONS --}}
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</body>
</html>
