<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel del Alumno</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <x-students-navbar/>

    <div class="flex-grow p-4 sm:p-6">

        <div class="max-w-4xl w-full mx-auto bg-white rounded-2xl shadow-xl p-6 sm:p-10">

            {{-- TÍTULO --}}
            <h1 class="text-2xl sm:text-4xl font-bold text-gray-800 mb-4">
                🎓 Panel del Alumno
            </h1>

            {{-- INFO DEL ALUMNO --}}
            <p class="text-base sm:text-lg text-gray-600 mb-8 sm:mb-10 leading-relaxed">
                Bienvenido,
                <span class="font-semibold text-indigo-700">
                    {{ $student->name }} {{ $student->last_name_f }} {{ $student->last_name_m }}
                </span>
                <br>
                <span class="text-sm text-gray-500">
                    Matrícula: {{ $student->enrollment }}
                </span>
            </p>

            {{-- ADVERTENCIA DE CONTRASEÑA --}}
            @if ($isDefaultPassword)
                <div class="mb-6 p-4 bg-red-100 border border-red-300 rounded-xl text-red-700 text-sm sm:text-base">
                    ⚠️ Estás usando tu contraseña por defecto (tu matrícula).  
                    Por seguridad, es necesario cambiarla.

                    <a href="{{ route('students.panel.change_password_form') }}"
                       class="font-bold underline ml-2">
                        Cambiar contraseña
                    </a>
                </div>
            @endif

            {{-- TARJETAS --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-6">

                <a href="{{ route('students.panel.schedule') }}"
                   class="p-5 sm:p-6 bg-blue-50 rounded-xl shadow hover:shadow-lg transition text-center">
                    <div class="text-4xl sm:text-5xl mb-3">📅</div>
                    <div class="text-lg sm:text-xl font-semibold text-gray-800">Mi horario</div>
                </a>

                <a href="{{ route('students.panel.advisories') }}"
                   class="p-5 sm:p-6 bg-purple-50 rounded-xl shadow hover:shadow-lg transition text-center">
                    <div class="text-4xl sm:text-5xl mb-3">🧑‍🏫</div>
                    <div class="text-lg sm:text-xl font-semibold text-gray-800">Asesorías asignadas</div>
                </a>

                <a href="{{ route('students.panel.manuals') }}"
                   class="p-5 sm:p-6 bg-green-50 rounded-xl shadow hover:shadow-lg transition text-center">
                    <div class="text-4xl sm:text-5xl mb-3">📘</div>
                    <div class="text-lg sm:text-xl font-semibold text-gray-800">Manuales</div>
                </a>

            </div>

            {{-- BOTÓN CERRAR SESIÓN --}}
            <form action="{{ route('logout') }}" method="POST" class="mt-10 text-center">
                @csrf
                <button class="px-6 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 
                               text-sm sm:text-base font-semibold shadow">
                    Cerrar sesión
                </button>
            </form>

        </div>

    </div>

    <x-basic-sciences-footer />

</body>
</html>
