<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Notificaciones</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen">

<x-students-navbar />

<div class="max-w-3xl mx-auto mt-10 bg-white shadow p-6 rounded-xl">

    <h1 class="text-3xl font-bold mb-6">🔔 Notificaciones</h1>

    @forelse(Auth::user()->notifications as $notification)
        @php
            $data = $notification->data;
        @endphp

        <div class="border-b py-4">

            {{-- Mensaje principal --}}
            <p class="font-bold text-lg">
                {{ $data['message'] ?? 'Notificación recibida' }}
            </p>


            {{-- Maestro --}}
            <p class="text-gray-700">
                Maestro: {{ $data['teacher'] ?? 'No asignado' }}
            </p>


            {{-- Enlace --}}
            @if (!empty($data['advisory_id']))
                <a href="{{ route('students.panel.advisories', $data['advisory_id']) }}"
                   class="text-blue-600 hover:underline">
                    Ver asesoría
                </a>
            @else
                <span class="text-gray-500 text-sm">
                    (Sin enlace disponible)
                </span>
            @endif

        </div>

    @empty
        <p class="text-gray-600 text-center py-6">No tienes notificaciones aún.</p>
    @endforelse

</div>

</body>
</html>
