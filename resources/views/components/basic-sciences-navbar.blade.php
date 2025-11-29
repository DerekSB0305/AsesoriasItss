<nav class="bg-[#0B3D7E] text-white shadow-md py-3 w-full" x-data="{ menu:false }">

    <div class="max-w-7xl mx-auto px-6 flex items-center justify-between">

        <div class="flex items-center space-x-4 flex-shrink-0">
            <img src="{{ asset('images/Logo_tecnm.jpg') }}" class="h-14 md:h-16" alt="TecNM">
            <img src="{{ asset('images/Logo_itss.png') }}" class="h-12 md:h-16" alt="ITSS">
        </div>

        <button id="menu-btn"
                @click="menu = !menu"
                class="md:hidden text-3xl focus:outline-none">
            ☰
        </button>

        <div class="hidden md:flex flex-1 justify-center space-x-10 text-sm font-medium">

            <div x-data="{open:false}" class="relative">
                <button @click="open=!open" class="hover:text-gray-300">Administración ▼</button>
                <div x-show="open"
                     @click.outside="open=false"
                     class="absolute left-1/2 -translate-x-1/2 mt-2 w-48 bg-white text-gray-800 rounded shadow-lg py-2 z-20">
                    <a href="{{ route('basic_sciences.teachers.index') }}" class="block px-4 py-2 hover:bg-gray-100">Maestros</a>
                    <a href="{{ route('basic_sciences.students.index') }}" class="block px-4 py-2 hover:bg-gray-100">Alumnos</a>
                    <a href="{{ route('basic_sciences.users.index') }}" class="block px-4 py-2 hover:bg-gray-100">Usuarios</a>
                    <a href="{{ route('basic_sciences.administratives.index') }}" class="block px-4 py-2 hover:bg-gray-100">Administrativos</a>
                </div>
            </div>

            <div x-data="{open:false}" class="relative">
                <button @click="open=!open" class="hover:text-gray-300">Académico ▼</button>
                <div x-show="open"
                     @click.outside="open=false"
                     class="absolute left-1/2 -translate-x-1/2 mt-2 w-56 bg-white text-gray-800 rounded shadow-lg py-2 z-20">
                    <a href="{{ route('basic_sciences.requests.index') }}" class="block px-4 py-2 hover:bg-gray-100">Solicitudes</a>
                    <a href="{{ route('basic_sciences.advisories.index') }}" class="block px-4 py-2 hover:bg-gray-100">Asesorías</a>
                    <a href="{{ route('basic_sciences.teacher_subjects.index') }}" class="block px-4 py-2 hover:bg-gray-100">Materias-Maestro</a>
                    <a href="{{ route('basic_sciences.subjects.index') }}" class="block px-4 py-2 hover:bg-gray-100">Materias</a>
                </div>
            </div>

            <div x-data="{open:false}" class="relative">
                <button @click="open=!open" class="hover:text-gray-300">Archivos ▼</button>
                <div x-show="open"
                     @click.outside="open=false"
                     class="absolute left-1/2 -translate-x-1/2 mt-2 w-48 bg-white text-gray-800 rounded shadow-lg py-2 z-20">
                    <a href="{{ route('basic_sciences.manuals.index') }}" class="block px-4 py-2 hover:bg-gray-100">Manuales</a>
                    <a href="{{ route('basic_sciences.documents.index') }}" class="block px-4 py-2 hover:bg-gray-100">Documentos</a>
                </div>
            </div>

        </div>

        <div class="hidden md:flex items-center space-x-3 flex-shrink-0">
            <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" 
                     class="h-6 w-6 text-gray-700" fill="none"
                     viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5.121 17.804A4 4 0 0112 15a4 4 0 016.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="hover:text-gray-300 text-xs">Cerrar sesión</button>
            </form>
        </div>

    </div>

    <div id="mobile-menu"
         x-show="menu"
         class="md:hidden bg-[#0B3D7E] px-6 pb-4 space-y-3 text-sm">

        <a class="block hover:text-gray-300" href="{{ route('basic_sciences.requests.index') }}">Solicitudes</a>
        <a class="block hover:text-gray-300" href="{{ route('basic_sciences.teachers.index') }}">Maestros</a>
        <a class="block hover:text-gray-300" href="{{ route('basic_sciences.students.index') }}">Alumnos</a>
        <a class="block hover:text-gray-300" href="{{ route('basic_sciences.advisories.index') }}">Asesorías</a>
        <a class="block hover:text-gray-300" href="{{ route('basic_sciences.teacher_subjects.index') }}">Materias-Maestro</a>
        <a class="block hover:text-gray-300" href="{{ route('basic_sciences.subjects.index') }}">Materias</a>
        <a class="block hover:text-gray-300" href="{{ route('basic_sciences.manuals.index') }}">Manuales</a>
        <a class="block hover:text-gray-300" href="{{ route('basic_sciences.documents.index') }}">Documentos</a>
        <a class="block hover:text-gray-300" href="{{ route('basic_sciences.users.index') }}">Usuarios</a>
        <a class="block hover:text-gray-300" href="{{ route('basic_sciences.administratives.index') }}">Administrativos</a>

        <div class="pt-3 border-t border-gray-300">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="w-full text-left hover:text-gray-300">Cerrar sesión</button>
            </form>
        </div>
    </div>

</nav>
