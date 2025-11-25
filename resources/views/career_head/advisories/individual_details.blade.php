<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles de Asesoría</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- NAVBAR --}}
<x-career-head-navbar />


    <div class="flex-1 p-8">

        <div class="max-w-4xl mx-auto bg-white shadow-lg rounded-xl p-6">

            {{-- BOTÓN VOLVER --}}
            <a href="{{ route('career_head.advisories.index') }}"
               class="inline-flex items-center bg-gray-200 text-gray-800 px-4 py-2 rounded-md hover:bg-gray-300 transition mb-4">
                <span class="mr-1">←</span> Volver
            </a>

            {{-- TÍTULO --}}
            <h1 class="text-2xl font-bold mb-4 text-gray-800">
                Detalles de Asesoría #{{ $advisory->advisory_id }}
            </h1>

            {{-- INFORMACIÓN GENERAL --}}
            <div class="grid grid-cols-2 gap-4 text-gray-700 mb-6">

                <div>
                    <p><strong>Maestro:</strong><br>
                        {{ $advisory->teacherSubject->teacher->name }}
                        {{ $advisory->teacherSubject->teacher->last_name_f }}
                        {{ $advisory->teacherSubject->teacher->last_name_m }}
                    </p>
                </div>

                <div>
                    <p><strong>Materia:</strong><br>
                        {{ $advisory->teacherSubject->subject->name }}
                    </p>
                </div>

                <div>
                    <p><strong>Carrera:</strong><br>
                        {{ $advisory->teacherSubject->career->name }}
                    </p>
                </div>

                <div>
                    <p><strong>Periodo:</strong><br>
                        📅 Del {{ \Carbon\Carbon::parse($advisory->start_date)->format('d/m/Y') }}
                        al {{ \Carbon\Carbon::parse($advisory->end_date)->format('d/m/Y') }}
                    </p>
                </div>

                <div>
                    <p><strong>Día y Horario:</strong><br>
                        🕒 {{ ucfirst($advisory->day_of_week) }}
                        {{ \Carbon\Carbon::parse($advisory->start_time)->format('H:i') }}
                        -
                        {{ \Carbon\Carbon::parse($advisory->end_time)->format('H:i') }}
                    </p>
                </div>

                <div>
                    <p><strong>Aula:</strong><br>
                        {{ $advisory->classroom ?? 'N/A' }}
                    </p>
                </div>

                <div>
                    <p><strong>Edificio:</strong><br>
                        {{ $advisory->building ?? 'N/A' }}
                    </p>
                </div>

                <div>
                    <p><strong>Estado:</strong><br>
                        {{ $advisory->advisoryDetail->status }}
                    </p>
                </div>

            </div>

            {{-- ARCHIVO DE ASIGNACIÓN --}}
            <div class="p-4 bg-gray-50 border rounded-lg shadow-sm mb-8">
                <p class="text-sm font-semibold text-gray-600">Archivo de asignación</p>

                @if($advisory->assignment_file)

                    @php
                        $path = asset('storage/' . $advisory->assignment_file);
                        $ext = strtolower(pathinfo($advisory->assignment_file, PATHINFO_EXTENSION));
                        $isImage = in_array($ext, ['jpg','jpeg','png']);
                        $isPDF = $ext === 'pdf';
                        $isWord = in_array($ext, ['doc','docx']);
                    @endphp

                    {{-- PDF --}}
                    @if($isPDF)
                        <iframe src="{{ $path }}"
                                class="w-full h-64 mt-3 border rounded-lg"
                                frameborder="0"></iframe>
                    @endif

                    {{-- Imagen --}}
                    @if($isImage)
                        <img src="{{ $path }}"
                             class="w-40 h-40 object-cover rounded-lg mt-3 border shadow">
                    @endif

                    {{-- Word --}}
                    @if($isWord)
                        <div class="mt-3 flex items-center gap-3">
                            <img src="https://cdn-icons-png.flaticon.com/512/281/281760.png" width="50">
                            <a href="{{ $path }}" target="_blank"
                               class="text-blue-600 underline font-semibold">
                                📄 Descargar archivo Word
                            </a>
                        </div>
                    @endif

                    <a href="{{ $path }}" target="_blank"
                       class="text-blue-600 underline font-semibold mt-2 inline-block">
                        Abrir archivo
                    </a>

                @else
                    <p class="text-gray-500 italic mt-2">No disponible</p>
                @endif
            </div>


            {{-- RESUMEN ALUMNOS --}}
            <h2 class="text-xl font-semibold mb-3 text-gray-800">Resumen de alumnos</h2>

            <div class="flex gap-6 mb-6">
                <p><strong>Total:</strong> {{ $total }}</p>
                <p class="text-blue-600"><strong>Hombres:</strong> {{ $hombres }}</p>
                <p class="text-pink-600"><strong>Mujeres:</strong> {{ $mujeres }}</p>
            </div>


            {{-- LISTA DE ALUMNOS --}}
            <h2 class="text-xl font-semibold mb-3 text-gray-800">Lista de alumnos</h2>

            <table class="w-full border text-sm mb-8">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="border px-3 py-2">Matrícula</th>
                        <th class="border px-3 py-2">Nombre</th>
                        <th class="border px-3 py-2">Género</th>
                        <th class="border px-3 py-2">Carrera</th>
                    </tr>
                </thead>

                <tbody>
                @foreach($students as $stu)
                    <tr>
                        <td class="border px-3 py-2">{{ $stu->enrollment }}</td>
                        <td class="border px-3 py-2">
                            {{ $stu->name }} {{ $stu->last_name_f }} {{ $stu->last_name_m }}
                        </td>
                        <td class="border px-3 py-2">{{ $stu->gender }}</td>
                        <td class="border px-3 py-2">{{ $stu->career->name }}</td>
                    </tr>
                @endforeach
                </tbody>
            </table>


            {{-- REPORTES DEL MAESTRO --}}
            <h2 class="text-xl font-semibold mt-8 mb-4 text-gray-800">Reportes del Maestro</h2>

            @if($reports->isEmpty())
                <p class="text-gray-500 italic">No hay reportes disponibles.</p>
            @else
                <div class="space-y-4">
                    @foreach($reports as $report)
                        @php
                            $path = asset('storage/' . $report->file_path);
                            $ext = strtolower(pathinfo($report->file_path, PATHINFO_EXTENSION));
                        @endphp

                        <div class="p-4 bg-gray-50 border rounded-lg shadow-sm">

                            <p class="font-semibold text-gray-700">
                                📘 {{ $report->description }}
                            </p>

                            {{-- PDF --}}
                            @if($ext === 'pdf')
                                <iframe src="{{ $path }}"
                                        class="w-full h-64 mt-3 border rounded-lg"
                                        frameborder="0"></iframe>
                            @endif

                            {{-- Imagen --}}
                            @if(in_array($ext, ['jpg','jpeg','png']))
                                <img src="{{ $path }}"
                                     class="w-40 h-40 object-cover rounded-lg mt-3 border shadow">
                            @endif

                            {{-- Word --}}
                            @if(in_array($ext, ['doc','docx']))
                                <div class="mt-3 flex items-center gap-3">
                                    <img src="https://cdn-icons-png.flaticon.com/512/281/281760.png" width="50">
                                    <a href="{{ $path }}" target="_blank"
                                       class="text-blue-600 underline font-semibold">
                                        📄 Descargar archivo Word
                                    </a>
                                </div>
                            @endif

                            <a href="{{ $path }}" target="_blank"
                               class="text-blue-600 underline font-semibold mt-2 inline-block">
                                Abrir archivo
                            </a>
                        </div>
                    @endforeach
                </div>
            @endif

        </div>

    </div>

    {{-- FOOTER --}}
    <x-basic-sciences-footer />

</body>
</html>
