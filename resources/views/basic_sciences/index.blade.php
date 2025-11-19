<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio Ciencias Básicas</title>
    @vite('resources/css/app.css')

    <!-- Material Icons (Google) -->
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
</head>

<body class="bg-gray-100 min-h-screen">

    {{-- NAVBAR --}}
    <x-basic-sciences-navbar />

    <div class="p-10">

        <h1 class="text-3xl font-extrabold text-gray-800 mb-8 text-center">
            Bienvenido al Panel de Ciencias Básicas
        </h1>

        {{-- GRID DE CARDS --}}
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">

            {{-- ADMINISTRATIVOS --}}
            <a href="{{ route('basic_sciences.administratives.index') }}"
               class="bg-white shadow-lg rounded-xl p-6 hover:shadow-2xl transition transform hover:-translate-y-1 flex flex-col items-center gap-4">

                <span class="material-icons text-blue-700" style="font-size:80px;">admin_panel_settings</span>

                <h2 class="text-center font-bold text-lg text-gray-700">
                    👩‍💼 Gestionar Administrativos
                </h2>
            </a>

            {{-- MAESTROS --}}
            <a href="{{ route('basic_sciences.teachers.index') }}"
               class="bg-white shadow-lg rounded-xl p-6 hover:shadow-2xl transition transform hover:-translate-y-1 flex flex-col items-center gap-4">

                <span class="material-icons text-indigo-700" style="font-size:80px;">school</span>

                <h2 class="text-center font-bold text-lg text-gray-700">
                    👨‍🏫 Gestionar Maestros
                </h2>
            </a>

            {{-- ASIGNAR MATERIAS --}}
            <a href="{{ route('basic_sciences.teacher_subjects.index') }}"
               class="bg-white shadow-lg rounded-xl p-6 hover:shadow-2xl transition transform hover:-translate-y-1 flex flex-col items-center gap-4">

                <span class="material-icons text-green-700" style="font-size:80px;">assignment_ind</span>

                <h2 class="text-center font-bold text-lg text-gray-700">
                    📘 Asignar Materias a Maestros
                </h2>
            </a>

            {{-- ESTUDIANTES --}}
            <a href="{{ route('basic_sciences.students.index') }}"
               class="bg-white shadow-lg rounded-xl p-6 hover:shadow-2xl transition transform hover:-translate-y-1 flex flex-col items-center gap-4">

                <span class="material-icons text-purple-700" style="font-size:80px;">groups</span>

                <h2 class="text-center font-bold text-lg text-gray-700">
                    🎓 Ver Estudiantes
                </h2>
            </a>

            {{-- SOLICITUDES --}}
            <a href="{{ route('basic_sciences.requests.index') }}"
               class="bg-white shadow-lg rounded-xl p-6 hover:shadow-2xl transition transform hover:-translate-y-1 flex flex-col items-center gap-4">

                <span class="material-icons text-yellow-600" style="font-size:80px;">description</span>

                <h2 class="text-center font-bold text-lg text-gray-700">
                    📝 Ver Solicitudes
                </h2>
            </a>

            {{-- ASESORÍAS --}}
            <a href="{{ route('basic_sciences.advisories.index') }}"
               class="bg-white shadow-lg rounded-xl p-6 hover:shadow-2xl transition transform hover:-translate-y-1 flex flex-col items-center gap-4">

                <span class="material-icons text-red-700" style="font-size:80px;">event_available</span>

                <h2 class="text-center font-bold text-lg text-gray-700">
                    🧩 Gestionar Asesorías
                </h2>
            </a>

            {{-- USUARIOS --}}
            <a href="{{ route('basic_sciences.users.index') }}"
               class="bg-white shadow-lg rounded-xl p-6 hover:shadow-2xl transition transform hover:-translate-y-1 flex flex-col items-center gap-4">

                <span class="material-icons text-gray-700" style="font-size:80px;">people_alt</span>

                <h2 class="text-center font-bold text-lg text-gray-700">
                    👥 Ver Usuarios
                </h2>
            </a>

            {{-- MANUALES --}}
            <a href="{{ route('basic_sciences.manuals.index') }}"
               class="bg-white shadow-lg rounded-xl p-6 hover:shadow-2xl transition transform hover:-translate-y-1 flex flex-col items-center gap-4">

                <span class="material-icons text-teal-700" style="font-size:80px;">menu_book</span>

                <h2 class="text-center font-bold text-lg text-gray-700">
                    📘 Ver Manuales
                </h2>
            </a>

        </div>

    </div>

    {{-- FOOTER --}}
    <x-basic-sciences-footer />

</body>
</html>
