<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Cambiar contraseña</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex items-center justify-center flex-col">
    <x-students-navbar/>
    <div class="flex-grow p-6">

    <div class="max-w-md w-full bg-white p-8 rounded-xl shadow-xl">

        <a href="{{ route('students.panel.index') }}"
           class="text-indigo-600 hover:text-indigo-800 block mb-4">
            ← Volver al panel
        </a>

        <h1 class="text-2xl font-bold mb-6 text-gray-800">🔐 Cambiar contraseña</h1>

        <form action="{{ route('students.panel.change_password') }}" method="POST" class="space-y-5">
            @csrf

            <div>
                <label class="block font-semibold mb-1">Nueva contraseña:</label>
                <input type="password" name="password"
                       class="w-full border rounded-lg p-2" required>
            </div>

            <div>
                <label class="block font-semibold mb-1">Confirmar contraseña:</label>
                <input type="password" name="password_confirmation"
                       class="w-full border rounded-lg p-2" required>
            </div>

            <button type="submit"
                class="w-full py-2 bg-indigo-600 text-white rounded-lg hover:bg-indigo-700 transition">
                Guardar cambios
            </button>
        </form>

    </div>
    </div>
 <x-basic-sciences-footer/>
</body>
</html>
