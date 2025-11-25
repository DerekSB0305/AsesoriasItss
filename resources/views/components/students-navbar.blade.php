<nav class="bg-[#0B3D7E] text-white shadow-md py-3 w-full">
    <div class="max-w-7xl mx-auto px-6 flex items-center justify-between">

        {{-- LOGO --}}
        <div class="flex items-center space-x-3">
            <img src="{{ asset('images/tecnm_logo.png') }}" class="h-10" alt="TecNM">
        </div>

        {{-- MENÚ DEL ALUMNO --}}
        <div class="flex space-x-8 text-sm font-medium">

            <a href="{{ route('students.panel.index') }}" class="hover:text-gray-300">
                Inicio
            </a>

            <a href="{{ route('students.panel.schedule') }}" class="hover:text-gray-300">
                Mi horario
            </a>

            <a href="{{ route('students.panel.advisories') }}" class="hover:text-gray-300">
                Asesorías
            </a>

            <a href="{{ route('students.panel.manuals') }}" class="hover:text-gray-300">
                Manuales
            </a>
        </div>

        {{-- NOTIFICACIONES + PERFIL --}}
        <div class="flex items-center space-x-6">

            {{-- CAMPANITA --}}
            <div class="relative">
                <a href="{{ route('students.panel.notifications') }}" 
                   class="relative text-2xl hover:text-gray-300">
                    🔔
                    @if(Auth::user()->unreadNotifications->count() > 0)
                        <span class="absolute -top-2 -right-2 bg-red-600 text-white text-xs px-2 py-0.5 rounded-full">
                            {{ Auth::user()->unreadNotifications->count() }}
                        </span>
                    @endif
                </a>
            </div>

            {{-- AVATAR --}}
            <div class="w-10 h-10 bg-gray-300 rounded-full flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6 text-gray-700" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M5.121 17.804A4 4 0 0112 15a4 4 0 016.879 2.804M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>

            {{-- LOGOUT --}}
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="text-xs hover:text-gray-300">
                    Cerrar sesión
                </button>
            </form>

        </div>

    </div>
</nav>
