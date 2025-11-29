<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Contraseña</title>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <div class="fixed top-0 left-0 w-full z-50 shadow">
        <x-basic-sciences-navbar />
    </div>

    <main class="flex-1 mt-32 mb-20 px-4 flex items-center justify-center">

        <div class="bg-white w-full max-w-lg shadow-xl p-6 sm:p-8 rounded-xl border-t-4 border-[#0B3D7E]">

            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0B3D7E] mb-6 text-center flex items-center justify-center gap-2">
                🔐 Editar Contraseña
            </h1>

            <div class="mb-6">
                <a href="{{ route('basic_sciences.users.index') }}"
                   class="inline-block px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg font-semibold transition">
                    ← Volver
                </a>
            </div>

            <form method="POST" action="{{ route('basic_sciences.users.update', $user) }}" class="space-y-5">
                @csrf
                @method('PUT')

                @if ($errors->any())
                    <div class="bg-red-100 border border-red-300 text-red-700 p-3 rounded">
                        <ul class="list-disc ml-5 text-sm">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (session('success'))
                    <div class="bg-green-100 border border-green-300 text-green-700 p-3 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div>
                    <label class="block mb-1 font-semibold text-gray-700">Usuario</label>
                    <input type="text" value="{{ $user->user }}" disabled
                           class="w-full border border-gray-300 rounded-lg p-3 bg-gray-100 text-gray-600 cursor-not-allowed">
                </div>

                <div>
                    <label class="block mb-1 font-semibold text-gray-700">Nueva contraseña</label>
                    <input type="password"
                           id="password"
                           name="password"
                           minlength="8"
                           required
                           class="w-full border border-gray-300 rounded-lg p-3 focus:ring-[#007BFF] focus:border-[#007BFF]">

                    <small id="msg"
                           class="text-red-600 text-sm hidden">
                        ⚠️ La contraseña debe tener al menos 8 caracteres.
                    </small>
                </div>

                <div>
                    <label class="block mb-1 font-semibold text-gray-700">Confirmar contraseña</label>
                    <input type="password"
                           name="password_confirmation"
                           required
                           class="w-full border border-gray-300 rounded-lg p-3 focus:ring-[#007BFF] focus:border-[#007BFF]">
                </div>

                <button type="submit"
                        class="w-full bg-[#28A745] text-white font-semibold py-3 rounded-lg shadow hover:bg-[#1e8d39] transition">
                    💾 Actualizar contraseña
                </button>

            </form>

        </div>

    </main>

    <div class="mt-auto">
        <x-basic-sciences-footer />
    </div>

    <script>
        const pass = document.getElementById('password');
        const msg = document.getElementById('msg');

        pass.addEventListener('input', () => {
            msg.classList.toggle('hidden', pass.value.length >= 8);
        });
    </script>

</body>
</html>
