<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Contraseña</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <x-basic-sciences-navbar />

    {{-- CONTENIDO --}}
    <div class="flex-grow flex items-center justify-center p-6">

        <div class="bg-white w-full max-w-lg shadow-xl p-8 rounded-xl border-t-4 border-[#0B3D7E]">

            <h1 class="text-3xl font-extrabold text-[#0B3D7E] mb-6 text-center flex items-center justify-center gap-2">
                🔐 Editar Contraseña
            </h1>

            {{-- BOTÓN VOLVER --}}
            <div class="mb-6">
                <a href="{{ route('basic_sciences.users.index') }}"
                   class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold">
                    ← Volver
                </a>
            </div>

            <form method="POST" action="{{ route('basic_sciences.users.update', $user) }}" class="space-y-5">
                @csrf
                @method('PUT')

                {{-- ERRORES --}}
                @if ($errors->any())
                <div class="bg-red-100 border border-red-300 text-red-700 p-3 rounded">
                    <ul class="list-disc ml-5 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif

                {{-- EXITO --}}
                @if (session('success'))
                <div class="bg-green-100 border border-green-300 text-green-700 p-3 rounded">
                    {{ session('success') }}
                </div>
                @endif

                <div class="mb-4">
                    <label class="block mb-1 font-semibold text-gray-700">Usuario</label>
                    <input type="text" value="{{ $user->user }}" disabled
                           class="w-full border-gray-300 border rounded-lg p-3 bg-gray-100 cursor-not-allowed">
                </div>

                {{-- NUEVA CONTRASEÑA --}}
                <div>
                    <label class="block mb-1 font-semibold text-gray-700">Nueva contraseña</label>
                    <input type="password" name="password" id="password"
                           class="w-full border-gray-300 border rounded-lg p-3 focus:ring-[#007BFF] focus:border-[#007BFF]"
                           minlength="8" required>

                    <small id="msg" class="text-red-600 hidden text-sm">
                        ⚠️ La contraseña debe tener mínimo 8 caracteres.
                    </small>
                </div>

                {{-- CONFIRMAR --}}
                <div>
                    <label class="block mb-1 font-semibold text-gray-700">Confirmar contraseña</label>
                    <input type="password" name="password_confirmation"
                           class="w-full border-gray-300 border rounded-lg p-3 focus:ring-[#007BFF] focus:border-[#007BFF]"
                           required>
                </div>

                {{-- BOTÓN --}}
                <button type="submit"
                    class="w-full bg-[#28A745] text-white font-semibold py-3 rounded-lg shadow hover:bg-[#16A085] transition">
                    💾 Actualizar contraseña
                </button>

            </form>

        </div>

    </div>

    <x-basic-sciences-footer />

</body>

<script>
    const pass = document.getElementById('password');
    const msg = document.getElementById('msg');

    pass.addEventListener('input', () => {
        msg.classList.toggle('hidden', pass.value.length >= 8);
    });
</script>

</html>

