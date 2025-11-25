<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- NAVBAR -->
    <nav class="bg-[#0B3D7E] text-white py-4 shadow-lg">
        <div class="max-w-6xl mx-auto px-6 flex justify-between items-center">
            <h1 class="text-xl font-bold">Sistema de Asesorías</h1>
            <a href="login" class="text-white hover:text-gray-200 font-medium">Inicio</a>
        </div>
    </nav>

    <!-- CONTENIDO -->
    <div class="flex-grow flex items-center justify-center p-6">

        <div class="bg-white shadow-xl rounded-2xl p-8 w-full max-w-md">

            <h2 class="text-3xl font-bold text-center text-gray-800 mb-6">
                Iniciar Sesión
            </h2>

            <!-- 📌 Mensaje general -->
            @if ($errors->has('general'))
                <div class="bg-red-100 border border-red-400 text-red-700 p-3 rounded mb-4">
                    {{ $errors->first('general') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="space-y-6">
                @csrf

                <!-- USUARIO -->
                <div>
                    <label for="user" class="block text-sm font-medium text-gray-700">Usuario</label>
                    <input id="user" type="text" name="user" value="{{ old('user') }}" required autofocus
                        class="mt-1 block w-full px-3 py-2 border 
                        {{ $errors->has('user') ? 'border-red-500' : 'border-gray-300' }}
                        rounded-lg shadow-sm focus:ring-[#007BFF] focus:border-[#007BFF]">

                    @error('user')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- CONTRASEÑA -->
                <div>
                    <label for="password" class="block text-sm font-medium text-gray-700">Contraseña</label>
                    <input id="password" type="password" name="password" required
                        class="mt-1 block w-full px-3 py-2 border 
                        {{ $errors->has('password') ? 'border-red-500' : 'border-gray-300' }}
                        rounded-lg shadow-sm focus:ring-[#007BFF] focus:border-[#007BFF]">

                    @error('password')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- BOTÓN -->
                <div>
                    <button type="submit"
                        class="w-full bg-[#007BFF] text-white py-2 rounded-lg font-semibold 
                        hover:bg-blue-700 transition duration-200 shadow-md">
                        Iniciar sesión
                    </button>
                </div>

            </form>

        </div>
    </div>

    <!-- FOOTER -->
    <footer class="bg-[#0B3D7E] text-white py-4 mt-10">
        <div class="max-w-6xl mx-auto px-6 text-center text-sm">
            © {{ date('Y') }} Sistema de Asesorías — Todos los derechos reservados.
        </div>
    </footer>

</body>
</html>
