<div>
    <nav class="bg-[#0B3D7E] text-white shadow-lg">
    <div class="max-w-7xl mx-auto px-6 py-4 flex justify-between items-center">

        {{-- LOGO / TÍTULO --}}
        <div class="flex items-center gap-3">
            <span class="material-icons text-3xl">account_balance</span>
            <h1 class="text-xl font-bold tracking-wide">
                Jefatura de División
            </h1>
        </div>

        {{-- ENLACES --}}
        <ul class="hidden md:flex gap-6 text-sm font-semibold">

            <li>
                <a href="{{ route('career_head.index') }}"
                   class="hover:text-gray-300 transition">
                    Inicio
                </a>
            </li>

            <li>
                <a href="{{ route('career_head.teachers.index') }}"
                   class="hover:text-gray-300 transition">
                    Maestros
                </a>
            </li>

            <li>
                <a href="{{ route('career_head.students.index') }}"
                   class="hover:text-gray-300 transition">
                    Alumnos
                </a>
            </li>

            <li>
                <a href="{{ route('career_head.advisories.index') }}"
                   class="hover:text-gray-300 transition">
                    Asesorías
                </a>
            </li>

            <li>
                <a href="{{ route('career_head.manuals.index') }}"
                   class="hover:text-gray-300 transition">
                    Manuales
                </a>
            </li>

        </ul>

        {{-- BOTÓN DE CERRAR SESIÓN --}}
         <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-xs hover:text-gray-300">
                    Cerrar sesión
                </button>
            </form>

    </div>

    {{-- MOBILE MENU --}}
    <div class="md:hidden bg-[#0B3D7E] px-6 pb-4">

        <a href="{{ route('career_head.index') }}"
           class="block py-2 border-b border-gray-600">Inicio</a>

        <a href="{{ route('career_head.teachers.index') }}"
           class="block py-2 border-b border-gray-600">Maestros</a>

        <a href="{{ route('career_head.students.index') }}"
           class="block py-2 border-b border-gray-600">Alumnos</a>

        <a href="{{ route('career_head.advisories.index') }}"
           class="block py-2 border-b border-gray-600">Asesorías</a>

        <a href="{{ route('career_head.manuals.index') }}"
           class="block py-2">Manuales</a>

    </div>
</nav>

{{-- GOOGLE ICONS --}}
<link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">

</div>