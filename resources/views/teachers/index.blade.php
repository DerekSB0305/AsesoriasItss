<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel del Maestro</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center p-6">

    <div class="max-w-3xl w-full bg-white rounded-xl shadow-xl p-8">

        {{-- Encabezado --}}
        <div class="text-center mb-8">
            <h1 class="text-3xl font-bold text-gray-800">👨‍🏫 Panel del Maestro</h1>

            <p class="text-lg text-gray-600 mt-2">
                Bienvenido,
                <span class="font-semibold text-indigo-700">
                    {{ Auth::user()->teacher->name }}
                    {{ Auth::user()->teacher->last_name_f }}
                    {{ Auth::user()->teacher->last_name_m }}
                </span>
            </p>
        </div>

        {{-- Acciones --}}
        <h2 class="text-xl font-semibold text-gray-800 mb-4">📌 Acciones disponibles</h2>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">

            {{-- Ver alumnos --}}
            <a href="{{ route('teachers.students.index') }}"
                class="flex items-center gap-3 p-4 bg-indigo-50 rounded-lg shadow-sm hover:bg-indigo-100 transition">
                <span class="text-2xl">📘</span>
                <span class="font-medium text-gray-800">Ver alumnos registrados</span>
            </a>

            {{-- Registrar alumno --}}
            <a href="{{ route('teachers.students.create') }}"
                class="flex items-center gap-3 p-4 bg-green-50 rounded-lg shadow-sm hover:bg-green-100 transition">
                <span class="text-2xl">➕</span>
                <span class="font-medium text-gray-800">Registrar alumno</span>
            </a>

            {{-- Ver solicitudes --}}
            <a href="{{ route('teachers.requests.index') }}"
                class="flex items-center gap-3 p-4 bg-yellow-50 rounded-lg shadow-sm hover:bg-yellow-100 transition">
                <span class="text-2xl">📄</span>
                <span class="font-medium text-gray-800">Ver solicitudes de asesoría</span>
            </a>

            {{-- Solicitar asesoría --}}
            <a href="{{ route('teachers.requests.create') }}"
                class="flex items-center gap-3 p-4 bg-blue-50 rounded-lg shadow-sm hover:bg-blue-100 transition">
                <span class="text-2xl">✏️</span>
                <span class="font-medium text-gray-800">Solicitar asesoría</span>
            </a>

            {{-- Ver asesorías --}}
            <a href="{{ route('teachers.advisories.index') }}"
                class="flex items-center gap-3 p-4 bg-purple-50 rounded-lg shadow-sm hover:bg-purple-100 transition">
                <span class="text-2xl">📅</span>
                <span class="font-medium text-gray-800">Ver asesorías programadas</span>
            </a>

        </div>

        {{-- Logout --}}
        <form method="POST" action="{{ route('logout') }}" class="mt-10 text-center">
            @csrf
            <button type="submit"
                class="px-6 py-2 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition">
                Cerrar sesión
            </button>
        </form>

    </div>

</body>

</html>
