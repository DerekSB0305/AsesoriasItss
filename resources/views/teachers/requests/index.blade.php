<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Solicitudes</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
    <x-teachers-navbar/>
     <div class="flex-grow p-6">

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
                
                <thead class="text-white uppercase text-xs font-semibold" style="background-color:#0B3D7E;">
                    <tr>
                        <th class="px-4 py-3">Alumno</th>
                        <th class="px-4 py-3">Materia</th>
                        <th class="px-4 py-3">Motivo</th>
                        <th class="px-4 py-3">Archivo</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700">

                    @foreach ($requests as $r)
                        <tr class="border-b hover:bg-gray-50 transition">

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

                            {{-- ARCHIVO CON VISTA PREVIA --}}
                            <td class="px-4 py-3">
                                @if($r->canalization_file)

                                    @php
                                        $path = asset('storage/' . $r->canalization_file);
                                        $extension = strtolower(pathinfo($r->canalization_file, PATHINFO_EXTENSION));
                                        $isImage = in_array($extension, ['jpg','jpeg','png']);
                                        $isPDF = $extension === 'pdf';
                                        $isWord = in_array($extension, ['doc','docx']);
                                    @endphp

                                    {{-- PDF --}}
                                    @if($isPDF)
                                        <div class="p-3 bg-gray-50 border rounded-lg shadow-sm">
                                            <p class="text-sm font-semibold text-gray-600">Vista previa PDF</p>

                                            <iframe src="{{ $path }}"
                                                    class="w-40 h-40 mt-2 border rounded"
                                                    frameborder="0"></iframe>

                                            <a href="{{ $path }}" target="_blank"
                                               class="text-blue-600 font-semibold underline mt-2 inline-block">
                                                📎 Abrir PDF en nueva pestaña
                                            </a>
                                        </div>
                                    @endif

                                    {{-- Imagen --}}
                                    @if($isImage)
                                        <div class="p-3 bg-gray-50 border rounded-lg shadow-sm">
                                            <p class="text-sm font-semibold text-gray-600">Vista previa imagen</p>

                                            <img src="{{ $path }}"
                                                 class="w-40 h-40 object-cover rounded-lg mt-2 border shadow">

                                            <a href="{{ $path }}" target="_blank"
                                               class="text-blue-600 font-semibold underline mt-2 inline-block">
                                                📎 Ver imagen completa
                                            </a>
                                        </div>
                                    @endif

                                    {{-- Word --}}
                                    @if($isWord)
                                        <div class="p-3 bg-blue-50 border border-blue-200 rounded-lg shadow-sm flex items-center gap-3">
                                            <img src="https://cdn-icons-png.flaticon.com/512/281/281760.png"
                                                 class="w-10 h-10">
                                            <div>
                                                <p class="text-sm font-semibold text-blue-700">Documento Word</p>
                                                <a href="{{ $path }}" target="_blank"
                                                   class="text-blue-600 underline font-semibold text-sm">
                                                    📄 Descargar archivo Word
                                                </a>
                                            </div>
                                        </div>
                                    @endif

                                    {{-- Otro tipo de archivo --}}
                                    @if(!$isPDF && !$isImage && !$isWord)
                                        <a href="{{ $path }}" target="_blank"
                                           class="text-blue-600 underline font-semibold">
                                            Ver archivo
                                        </a>
                                    @endif

                                @else
                                    <span class="text-gray-500 italic">No adjunto</span>
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
</div>
    <x-basic-sciences-footer />
</body>
</html>
