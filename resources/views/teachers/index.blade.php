@php
    $user = Auth::user();
    $teacher = $user->teacher;
    $isDefaultPassword = Hash::check($teacher->teacher_user, $user->password);
@endphp

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel del Maestro</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <x-teachers-navbar/>

    {{-- CONTENIDO --}}
    <div class="flex-grow flex items-center justify-center p-6">

        <div class="max-w-4xl w-full bg-white rounded-2xl shadow-xl p-10">

            {{-- Encabezado --}}
            <div class="text-center mb-10">
                <h1 class="text-4xl font-extrabold text-gray-800">👨‍🏫 Panel del Maestro</h1>

                <p class="text-xl text-gray-600 mt-3">
                    Bienvenido,
                    <span class="font-semibold text-indigo-700">
                        {{ Auth::user()->teacher->name }}
                        {{ Auth::user()->teacher->last_name_f }}
                        {{ Auth::user()->teacher->last_name_m }}
                    </span>
                </p>
            </div>

            @if ($isDefaultPassword)
                <div class="mb-8 p-4 rounded-xl bg-red-100 border border-red-300 shadow">
                    <h2 class="text-xl font-bold text-red-700 mb-1">⚠️ Es necesario actualizar tu contraseña</h2>
                    <p class="text-red-600">
                        Actualmente estás usando tu contraseña por defecto (tu usuario).  
                        Por seguridad, cambia tu contraseña lo antes posible.
                    </p>

                    <a href="{{ route('password.change.form') }}"
                    class="inline-block mt-3 px-4 py-2 bg-red-600 text-white rounded-lg
                        hover:bg-red-700 shadow transition">
                        Cambiar contraseña
                    </a>
                </div>
            @endif

            {{-- Acciones --}}
            <h2 class="text-2xl font-semibold text-gray-800 mb-6">📌 Acciones disponibles</h2>

            @php
                $teacher = Auth::user()->teacher;
                $tutor = $teacher->tutor;
                $basic = $teacher->science_department;
            @endphp

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                {{-- TUTOR NO BÁSICAS --}}
                @if ($tutor && !$basic)

                    <a href="{{ route('teachers.students.index') }}"
                       class="flex flex-col items-center justify-center gap-3 p-6 rounded-2xl shadow-md 
                              hover:shadow-2xl transition bg-white border border-gray-200 hover:bg-blue-50">
                        <span class="text-5xl">📘</span>
                        <span class="text-xl font-semibold text-gray-800">Ver alumnos registrados</span>
                    </a>

                    <a href="{{ route('teachers.students.create') }}"
                       class="flex flex-col items-center justify-center gap-3 p-6 rounded-2xl shadow-md 
                              hover:shadow-2xl transition bg-white border border-gray-200 hover:bg-green-50">
                        <span class="text-5xl">➕</span>
                        <span class="text-xl font-semibold text-gray-800">Registrar alumno</span>
                    </a>

                    <a href="{{ route('teachers.requests.index') }}"
                       class="flex flex-col items-center justify-center gap-3 p-6 rounded-2xl shadow-md
                              hover:shadow-2xl transition bg-white border border-gray-200 hover:bg-yellow-50">
                        <span class="text-5xl">📄</span>
                        <span class="text-xl font-semibold text-gray-800">Ver solicitudes de asesoría</span>
                    </a>

                    <a href="{{ route('teachers.requests.create') }}"
                       class="flex flex-col items-center justify-center gap-3 p-6 rounded-2xl shadow-md
                              hover:shadow-2xl transition bg-white border border-gray-200 hover:bg-indigo-50">
                        <span class="text-5xl">✏️</span>
                        <span class="text-xl font-semibold text-gray-800">Solicitar asesoría</span>
                    </a>

                @endif

                {{-- NO TUTOR, SÍ BÁSICAS --}}
                @if (!$tutor && $basic)

                    <a href="{{ route('teachers.advisories.index') }}"
                       class="flex flex-col items-center justify-center gap-3 p-6 rounded-2xl shadow-md 
                              hover:shadow-2xl transition bg-white border border-gray-200 hover:bg-purple-50">
                        <span class="text-5xl">📅</span>
                        <span class="text-xl font-semibold text-gray-800">Ver asesorías programadas</span>
                    </a>

                    <a href="{{ route('teachers.manuals.index') }}"
                       class="flex flex-col items-center justify-center gap-3 p-6 rounded-2xl shadow-md
                              hover:shadow-2xl transition bg-white border border-gray-200 hover:bg-cyan-50">
                        <span class="text-5xl">📘</span>
                        <span class="text-xl font-semibold text-gray-800">Manuales de materias</span>
                    </a>

                @endif

                {{-- TUTOR + BÁSICAS --}}
                @if ($tutor && $basic)

                    <a href="{{ route('teachers.students.index') }}"
                       class="flex flex-col items-center justify-center gap-3 p-6 rounded-2xl shadow-md 
                              hover:shadow-2xl transition bg-white border border-gray-200 hover:bg-blue-50">
                        <span class="text-5xl">📘</span>
                        <span class="text-xl font-semibold text-gray-800">Ver alumnos registrados</span>
                    </a>

                    <a href="{{ route('teachers.students.create') }}"
                       class="flex flex-col items-center justify-center gap-3 p-6 rounded-2xl shadow-md 
                              hover:shadow-2xl transition bg-white border border-gray-200 hover:bg-green-50">
                        <span class="text-5xl">➕</span>
                        <span class="text-xl font-semibold text-gray-800">Registrar alumno</span>
                    </a>

                    <a href="{{ route('teachers.requests.index') }}"
                       class="flex flex-col items-center justify-center gap-3 p-6 rounded-2xl shadow-md
                              hover:shadow-2xl transition bg-white border border-gray-200 hover:bg-yellow-50">
                        <span class="text-5xl">📄</span>
                        <span class="text-xl font-semibold text-gray-800">Ver solicitudes de asesoría</span>
                    </a>

                    <a href="{{ route('teachers.requests.create') }}"
                       class="flex flex-col items-center justify-center gap-3 p-6 rounded-2xl shadow-md
                              hover:shadow-2xl transition bg-white border border-gray-200 hover:bg-indigo-50">
                        <span class="text-5xl">✏️</span>
                        <span class="text-xl font-semibold text-gray-800">Solicitar asesoría</span>
                    </a>

                    <a href="{{ route('teachers.advisories.index') }}"
                       class="flex flex-col items-center justify-center gap-3 p-6 rounded-2xl shadow-md
                              hover:shadow-2xl transition bg-white border border-gray-200 hover:bg-purple-50">
                        <span class="text-5xl">📅</span>
                        <span class="text-xl font-semibold text-gray-800">Ver asesorías programadas</span>
                    </a>

                    <a href="{{ route('teachers.manuals.index') }}"
                       class="flex flex-col items-center justify-center gap-3 p-6 rounded-2xl shadow-md
                              hover:shadow-2xl transition bg-white border border-gray-200 hover:bg-cyan-50">
                        <span class="text-5xl">📘</span>
                        <span class="text-xl font-semibold text-gray-800">Manuales de materias</span>
                    </a>

                @endif

            </div>

            {{-- Logout --}}
            <form method="POST" action="{{ route('logout') }}" class="mt-12 text-center">
                @csrf
                <button type="submit"
                    class="px-8 py-3 bg-red-600 text-white rounded-lg font-semibold hover:bg-red-700 transition shadow">
                    Cerrar sesión
                </button>
            </form>

        </div>

    </div>

    {{-- FOOTER SIEMPRE ABAJO --}}
    <x-basic-sciences-footer />

</body>
</html>

