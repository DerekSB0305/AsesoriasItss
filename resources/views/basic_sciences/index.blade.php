<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio Ciencias Básicas</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen p-10">

    {{-- BOTÓN DE CERRAR SESIÓN --}}
    <div class="flex justify-end mb-6">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit"
                class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 transition">
                Cerrar sesión
            </button>
        </form>
    </div>

    <h1 class="text-3xl font-extrabold text-gray-800 mb-8 text-center">
        Bienvenido al Panel de Ciencias Básicas
    </h1>

    {{-- GRID DE CARDS --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

        {{-- ADMINISTRATIVOS --}}
        <a href="{{ route('basic_sciences.administratives.index') }}"
           class="bg-white shadow-lg rounded-xl p-4 hover:shadow-2xl transition transform hover:-translate-y-1">
            <img src="https://cdn-icons-png.flaticon.com/512/1995/1995574.png"
                 class="w-full h-40 object-contain bg-white p-4 rounded-lg mb-4">
            <h2 class="text-center font-bold text-lg text-gray-700">
                👩‍💼 Gestionar Administrativos
            </h2>
        </a>

        {{-- MAESTROS --}}
        <a href="{{ route('basic_sciences.teachers.index') }}"
           class="bg-white shadow-lg rounded-xl p-4 hover:shadow-2xl transition transform hover:-translate-y-1">
            <img src="https://cdn-icons-png.flaticon.com/512/1995/1995503.png"
                 class="w-full h-40 object-contain bg-white p-4 rounded-lg mb-4">
            <h2 class="text-center font-bold text-lg text-gray-700">
                👨‍🏫 Gestionar Maestros
            </h2>
        </a>

        {{-- ASIGNAR MATERIAS --}}
        <a href="{{ route('basic_sciences.teacher_subjects.index') }}"
           class="bg-white shadow-lg rounded-xl p-4 hover:shadow-2xl transition transform hover:-translate-y-1">
            <img src="https://cdn-icons-png.flaticon.com/512/2784/2784445.png"
                 class="w-full h-40 object-contain bg-white p-4 rounded-lg mb-4">
            <h2 class="text-center font-bold text-lg text-gray-700">
                📘 Asignar Materias a Maestros
            </h2>
        </a>

        {{-- ESTUDIANTES --}}
        <a href="{{ route('basic_sciences.students.index') }}"
           class="bg-white shadow-lg rounded-xl p-4 hover:shadow-2xl transition transform hover:-translate-y-1">
            <img src="https://cdn-icons-png.flaticon.com/512/3135/3135755.png"
                 class="w-full h-40 object-contain bg-white p-4 rounded-lg mb-4">
            <h2 class="text-center font-bold text-lg text-gray-700">
                🎓 Ver Estudiantes
            </h2>
        </a>

        {{-- SOLICITUDES --}}
        <a href="{{ route('basic_sciences.requests.index') }}"
           class="bg-white shadow-lg rounded-xl p-4 hover:shadow-2xl transition transform hover:-translate-y-1">
            <img src="https://cdn-icons-png.flaticon.com/512/3050/3050525.png"
                 class="w-full h-40 object-contain bg-white p-4 rounded-lg mb-4">
            <h2 class="text-center font-bold text-lg text-gray-700">
                📝 Ver Solicitudes
            </h2>
        </a>

        {{-- ASESORÍAS --}}
        <a href="{{ route('basic_sciences.advisories.index') }}"
           class="bg-white shadow-lg rounded-xl p-4 hover:shadow-2xl transition transform hover:-translate-y-1">
            <img src="https://cdn-icons-png.flaticon.com/512/3076/3076024.png"
                 class="w-full h-40 object-contain bg-white p-4 rounded-lg mb-4">
            <h2 class="text-center font-bold text-lg text-gray-700">
                🧩 Gestionar Asesorías
            </h2>
        </a>

        {{-- USUARIOS --}}
        <a href="{{ route('basic_sciences.users.index') }}"
           class="bg-white shadow-lg rounded-xl p-4 hover:shadow-2xl transition transform hover:-translate-y-1">
            <img src="https://cdn-icons-png.flaticon.com/512/3600/3600913.png"
                 class="w-full h-40 object-contain bg-white p-4 rounded-lg mb-4">
            <h2 class="text-center font-bold text-lg text-gray-700">
                👥 Ver Usuarios
            </h2>
        </a>

    </div>

</body>
</html>
