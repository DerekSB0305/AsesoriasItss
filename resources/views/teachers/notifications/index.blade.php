<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Notificaciones</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

<x-teachers-navbar />

<div class="max-w-3xl mx-auto bg-white shadow-lg rounded-xl p-6 my-10">

    <h1 class="text-3xl font-bold text-gray-800 mb-6">🔔 Notificaciones</h1>

    @forelse($notifications as $noti)
        <div class="border-b py-4">
            <p class="font-semibold text-gray-800">{{ $noti->data['title'] }}</p>

            <p class="text-gray-600 text-sm">
                Materia: <strong>{{ $noti->data['subject'] }}</strong><br>
                Docente asignado: <strong>{{ $noti->data['teacher'] }}</strong>
            </p>

            <a href="{{ route('teachers.advisories.index') }}"
               class="text-indigo-600 hover:underline">
                Ir a asesorías →
            </a>

            @if(is_null($noti->read_at))
                <form method="POST" action="{{ route('teachers.notifications.mark', $noti->id) }}">
                    @csrf
                    <button class="mt-2 text-sm text-green-600">Marcar como leída</button>
                </form>
            @endif
        </div>

    @empty
        <p class="text-center text-gray-500 py-10">No tienes notificaciones</p>
    @endforelse

</div>

</body>
</html>
