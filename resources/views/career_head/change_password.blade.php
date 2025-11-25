<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cambiar Contraseña</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- NAVBAR --}}
<x-career-head-navbar />


    <div class="flex-grow flex items-center justify-center p-6">

        <div class="bg-white shadow-2xl rounded-2xl p-8 w-full max-w-md border-t-4" style="border-color:#0B3D7E;">

            <h2 class="text-3xl font-extrabold text-center text-[#0B3D7E] mb-6">
                🔐 Cambiar Contraseña
            </h2>

            {{-- MENSAJE DE ERROR / ÉXITO --}}
            @if ($errors->any())
                <div class="bg-red-100 text-red-700 border border-red-300 p-4 rounded-lg mb-4 text-sm">
                    <strong>Se encontraron errores:</strong>
                    <ul class="mt-1 ml-4 list-disc">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(session('success'))
                <div class="bg-green-100 text-green-800 border border-green-300 p-4 rounded-lg mb-4 text-sm">
                    {{ session('success') }}
                </div>
            @endif

            {{-- FORMULARIO --}}
            <form method="POST" action="{{ route('career_head.change_password.update') }}" class="space-y-6">
                @csrf

                <div>
                    <label class="font-semibold text-gray-700">Nueva contraseña</label>
                    <input type="password"
                        name="password"
                        required
                        class="mt-1 w-full px-3 py-3 border rounded-lg shadow-sm
                        focus:ring-[#0B3D7E] focus:border-[#0B3D7E]">
                </div>

                <div>
                    <label class="font-semibold text-gray-700">Confirmar contraseña</label>
                    <input type="password"
                        name="password_confirmation"
                        required
                        class="mt-1 w-full px-3 py-3 border rounded-lg shadow-sm
                        focus:ring-[#0B3D7E] focus:border-[#0B3D7E]">
                </div>

                <button type="submit"
                    class="w-full py-3 text-white rounded-lg font-bold shadow text-center
                    hover:opacity-90 transition"
                    style="background-color:#28A745;">
                    Guardar nueva contraseña
                </button>

                <a href="{{ route('career_head.index') }}"
                    class="block w-full text-center mt-3 py-2 rounded-lg text-[#0B3D7E] font-semibold hover:text-blue-900">
                    ← Regresar a inicio
                </a>
            </form>

        </div>

    </div>

    {{-- FOOTER --}}
    <x-basic-sciences-footer />

</body>
</html>

