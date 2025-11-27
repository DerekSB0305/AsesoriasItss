<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- NAVBAR --}}
    <nav class="bg-[#0B3D7E] text-white py-4 shadow-lg">
        <div class="max-w-7xl mx-auto px-6 flex justify-between items-center">
            <h1 class="text-lg sm:text-xl font-bold">Sistema de Asesorías</h1>
            <a href="{{ route('login') }}" class="text-white hover:text-gray-200 font-medium">
                Inicio
            </a>
        </div>
    </nav>

    {{-- CONTENIDO --}}
    <div class="flex-grow flex flex-col items-center justify-center px-4 py-10">

        {{-- LOGOS EN FILA --}}
        <div class="flex items-center justify-center space-x-6 mb-8">
            <img src="{{ asset('images/Logo_tecnm.png') }}"
                 class="h-20 sm:h-28 w-auto object-contain"
                 alt="TecNM">

            <img src="{{ asset('images/Logo_itss.png') }}"
                 class="h-24 sm:h-32 w-auto object-contain"
                 alt="ITSS">
        </div>

        {{-- TARJETA DEL LOGIN --}}
        <div class="bg-white shadow-xl rounded-xl p-8 w-full max-w-md">

            <h2 class="text-3xl font-bold text-center text-gray-900 mb-6">
                Login
            </h2>

            @if ($errors->has('general'))
                <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4">
                    {{ $errors->first('general') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <div>
                    <label for="user" class="block text-sm font-medium text-gray-700">Usuario</label>
                    <input id="user" type="text" name="user" value="{{ old('user') }}" required
                        class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm
                               focus:ring-[#0B3D7E] focus:border-[#0B3D7E]">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <input id="password" type="password" name="password" required
                        class="mt-1 w-full px-3 py-2 border border-gray-300 rounded-lg shadow-sm
                               focus:ring-[#0B3D7E] focus:border-[#0B3D7E]">
                </div>

                <button type="submit"
                    class="w-full bg-[#28A745] hover:bg-green-700 text-white py-2 rounded-lg font-semibold shadow transition">
                    Iniciar sesión
                </button>
            </form>

            {{-- Recuperar contraseña --}}
            <div class="text-center mt-4">
                <button onclick="openModal()"
                    class="text-sm text-gray-600 hover:text-[#0B3D7E] hover:underline">
                    Recuperar contraseña
                </button>
            </div>

        </div>
    </div>

    {{-- FOOTER --}}
    <x-basic-sciences-footer />



    {{-- MODAL PERSONALIZADO --}}
    <div id="modal"
         class="fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm hidden flex items-center justify-center p-4">

        <div class="bg-white rounded-xl shadow-2xl p-6 w-full max-w-sm animate-fadeIn">

            <h3 class="text-xl font-bold text-[#0B3D7E] mb-3 text-center">
                Recuperar contraseña
            </h3>

            <p class="text-gray-700 text-center mb-6">
                Para recuperar su contraseña, por favor comuníquese con el
                <span class="font-semibold text-[#0B3D7E]">Departamento de Ciencias Básicas.</span>
            </p>

            <div class="flex justify-center">
                <button onclick="closeModal()"
                    class="px-5 py-2 bg-[#0B3D7E] text-white rounded-lg font-semibold hover:bg-[#072c5c] transition">
                    Entendido
                </button>
            </div>
        </div>
    </div>


    {{-- ANIMACIONES + SCRIPT --}}
    <style>
        .animate-fadeIn {
            animation: fadeIn .25s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: scale(0.9); }
            to   { opacity: 1; transform: scale(1); }
        }
    </style>

    <script>
        function openModal() {
            document.getElementById('modal').classList.remove('hidden');
        }
        function closeModal() {
            document.getElementById('modal').classList.add('hidden');
        }
    </script>

</body>
</html>


