<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Solicitudes</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen p-6">

<div class="max-w-5xl mx-auto bg-white shadow-lg rounded-xl p-8">

    {{-- Título y botón --}}
    <div class="flex items-center justify-between mb-6">
        <h1 class="text-3xl font-bold text-gray-800">📨 Mis Solicitudes de Asesoría</h1>

        <a href="{{ route('teachers.requests.create') }}"
           class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-700 transition">
            ➕ Nueva Solicitud
        </a>
    </div>

    {{-- Si no hay solicitudes --}}
    @if ($requests->count() == 0)
        <p class="text-gray-600 text-lg text-center py-6">
            No has solicitado asesorías aún.
        </p>
    @else

        {{-- Tabla --}}
        <div class="overflow-x-auto">
            <table class="w-full border-collapse rounded-lg overflow-hidden shadow-sm">
                
                <thead class="bg-gray-200 text-gray-700 text-sm uppercase">
                    <tr>
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Alumno</th>
                        <th class="px-4 py-3">Materia</th>
                        <th class="px-4 py-3">Motivo</th>
                        <th class="px-4 py-3">Archivo</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700">

                    @foreach ($requests as $r)
                        <tr class="border-b hover:bg-gray-50 transition">

                            <td class="px-4 py-3 font-semibold">{{ $r->request_id }}</td>

                            <td class="px-4 py-3">
                                {{ $r->student->enrollment }} — 
                                {{ $r->student->name }} {{ $r->student->last_name_f }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $r->subject->name }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $r->reason ?? '---' }}
                            </td>

                            <td class="px-4 py-3">
                                @if($r->canalization_file)
                                    <a href="{{ asset('storage/'.$r->canalization_file) }}"
                                       target="_blank"
                                       class="text-blue-600 hover:underline">
                                        Ver archivo
                                    </a>
                                @else
                                    <span class="text-gray-500">No adjunto</span>
                                @endif
                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>
        </div>

    @endif

   
           <div class="mt-6">
            <a href="{{ route('teachers.index') }}"
               class="text-blue-600 hover:text-blue-800 font-semibold">
                ← Volver al inicio del maestro
            </a>
        </div>

</div>

</body>
</html>
