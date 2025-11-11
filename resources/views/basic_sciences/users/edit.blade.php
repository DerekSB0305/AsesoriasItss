<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Contraseña</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 p-8">
    <div class="max-w-xl mx-auto bg-white p-6 rounded shadow">
        <h1 class="text-2xl font-bold mb-4">Editar Contraseña</h1>

      <form method="POST" action="{{ route('basic_sciences.users.update', $user) }}" class="space-y-4">
    @csrf
    @method('PUT')

    {{-- MENSAJES DE ERROR DE LARAVEL --}}
    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-3 rounded">
            <ul class="list-disc ml-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- MENSAJE DE EXITO --}}
    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-3 rounded">
            {{ session('success') }}
        </div>
    @endif

    <div>
        <label class="block mb-1 font-medium">Nueva contraseña</label>
        <input type="password" name="password" id="password"
               class="w-full border rounded p-2" minlength="8" required>
        <small id="msg" class="text-red-600 hidden">Mínimo 8 caracteres</small>
    </div>

    <div>
        <label class="block mb-1 font-medium">Confirmar contraseña</label>
        <input type="password" name="password_confirmation"
               class="w-full border rounded p-2" required>
    </div>

    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700">
        Actualizar
    </button>
</form>

<script>
    const pass = document.getElementById('password');
    const msg = document.getElementById('msg');

    pass.addEventListener('input', () => {
        if (pass.value.length < 8) {
            msg.classList.remove('hidden');
        } else {
            msg.classList.add('hidden');
        }
    });
</script>
    </div>
</body>
</html>
