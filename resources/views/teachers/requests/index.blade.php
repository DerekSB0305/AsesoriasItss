<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mis Solicitudes</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- NAVBAR --}}
    <div class="fixed top-0 left-0 w-full z-50 shadow">
        <x-teachers-navbar />
    </div>

    <main class="flex-1 mt-28 mb-20 px-4">

        <div class="max-w-7xl mx-auto bg-white shadow-xl rounded-xl p-6 sm:p-8">

            {{-- HEADER --}}
            <div class="flex flex-col sm:flex-row justify-between items-center mb-8 gap-4">

                <a href="{{ route('teachers.index') }}"
                    class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg font-semibold text-center">
                    ← Volver al inicio
                </a>

                <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0B3D7E]">
                    📨 Mis Solicitudes de Asesoría
                </h1>

                <a href="{{ route('teachers.requests.create') }}"
                    class="px-4 py-2 bg-[#28A745] hover:bg-[#218838] text-white rounded-lg shadow font-semibold">
                    ➕ Nueva Solicitud
                </a>

            </div>

            {{-- SIN SOLICITUDES --}}
            @if ($requests->count() == 0)
                <p class="text-center text-gray-600 text-lg py-8">
                    No has solicitado asesorías aún.
                </p>
            @else

            {{-- TABLA --}}
            <div class="overflow-x-auto rounded-xl border border-gray-200 shadow">

                <table class="min-w-full text-xs sm:text-sm">

                    <thead class="text-white uppercase font-semibold"
                        style="background-color:#0B3D7E;">
                        <tr>
                            <th class="px-4 py-3 whitespace-nowrap">Alumno</th>
                            <th class="px-4 py-3 whitespace-nowrap">Materia</th>
                            <th class="px-4 py-3 whitespace-nowrap">Motivo</th>
                            <th class="px-4 py-3 whitespace-nowrap">Archivo</th>
                        </tr>
                    </thead>

                    <tbody class="text-gray-800">

                        @foreach ($requests as $r)
                        <tr class="border-b hover:bg-gray-50 transition">

                            {{-- Alumno --}}
                            <td class="px-4 py-3 whitespace-nowrap font-semibold">
                                {{ $r->student->enrollment }} — 
                                {{ $r->student->name }} {{ $r->student->last_name_f }}
                            </td>

                            {{-- Materia --}}
                            <td class="px-4 py-3 whitespace-nowrap">
                                {{ $r->subject->name }}
                            </td>

                            {{-- Motivo --}}
                            <td class="px-4 py-3">
                                {{ $r->reason ?? '---' }}
                            </td>

                            {{-- ARCHIVO --}}
                            <td class="px-4 py-3">

                                @if($r->canalization_file)

                                    @php
                                        $path = asset('storage/' . $r->canalization_file);
                                        $extension = strtolower(pathinfo($r->canalization_file, PATHINFO_EXTENSION));

                                        $isPDF = $extension === 'pdf';
                                        $isImage = in_array($extension, ['jpg','jpeg','png']);
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
                                            class="text-blue-600 hover:text-blue-800 underline font-semibold mt-2 inline-block">
                                            📎 Abrir PDF
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
                                           class="text-blue-600 hover:text-blue-800 underline font-semibold mt-2 inline-block">
                                            📎 Ver imagen completa
                                        </a>
                                    </div>
                                    @endif

                                    {{-- Word --}}
                                    @if($isWord)
                                    <div class="p-3 bg-blue-50 border rounded-lg shadow-sm flex items-center gap-3">
                                        <img src="https://cdn-icons-png.flaticon.com/512/281/281760.png" class="w-10 h-10">
                                        <div>
                                            <p class="text-sm font-semibold text-blue-700">Documento Word</p>
                                            <a href="{{ $path }}" target="_blank"
                                               class="text-blue-600 hover:text-blue-800 underline font-semibold text-sm">
                                                📄 Descargar archivo
                                            </a>
                                        </div>
                                    </div>
                                    @endif

                                    {{-- Otros archivos --}}
                                    @if(!$isPDF && !$isImage && !$isWord)
                                    <a href="{{ $path }}" target="_blank"
                                       class="text-blue-600 underline font-semibold">
                                        📎 Ver archivo
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

            {{-- PAGINACIÓN --}}
            <div class="mt-6 flex justify-center">
                {{ $requests->links('vendor.pagination.tailwind') }}
            </div>

            @endif

            {{-- VOLVER --}}
            <div class="mt-6">
                <a href="{{ route('teachers.index') }}"
                    class="text-blue-600 hover:text-blue-800 font-semibold">
                    ← Volver al inicio del maestro
                </a>
            </div>

        </div>

    </main>

    <x-basic-sciences-footer />

</body>
</html>
