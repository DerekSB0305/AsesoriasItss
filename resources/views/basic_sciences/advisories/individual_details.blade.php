<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles de Asesoría</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen p-8">

<div class="max-w-4xl mx-auto bg-white shadow-lg rounded-xl p-6">

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
            <p><strong>Carrera de la materia:</strong><br>
                {{ $advisory->teacherSubject->career->name }}
            </p>
        </div>

        <div>
            <p><strong>Fecha / Hora:</strong><br>
                {{ $advisory->schedule }}
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

        {{-- ARCHIVO DE TAREA --}}
        <div class="p-4 bg-gray-50 border rounded-lg shadow-sm">
            <p class="text-sm font-semibold text-gray-600">Archivo de Tarea</p>

            @if($advisory->assignment_file)

                @php
                    $path = asset('storage/' . $advisory->assignment_file);
                    $extension = strtolower(pathinfo($advisory->assignment_file, PATHINFO_EXTENSION));
                    $isImage = in_array($extension, ['jpg','jpeg','png']);
                    $isPDF = $extension === 'pdf';
                    $isWord = in_array($extension, ['doc','docx']);
                @endphp

                {{-- Vista previa PDF --}}
                @if($isPDF)
                    <iframe src="{{ $path }}"
                            class="w-full h-64 mt-3 border rounded-lg"
                            frameborder="0"></iframe>
                    <a href="{{ $path }}" target="_blank"
                       class="text-blue-600 font-semibold underline mt-2 inline-block">
                        📎 Abrir PDF en nueva pestaña
                    </a>
                @endif

                {{-- Vista previa imagen --}}
                @if($isImage)
                    <img src="{{ $path }}"
                         class="w-40 h-40 object-cover rounded-lg mt-3 border shadow">
                    <a href="{{ $path }}" target="_blank"
                       class="text-blue-600 font-semibold underline mt-2 inline-block">
                        📎 Ver imagen completa
                    </a>
                @endif

                {{-- Word (descarga) --}}
                @if($isWord)
                    <div class="mt-3 flex items-center gap-3">
                        <img src="https://cdn-icons-png.flaticon.com/512/281/281760.png"
                             class="w-10 h-10">
                        <a href="{{ $path }}" target="_blank"
                           class="text-blue-600 underline font-semibold">
                            📄 Descargar archivo Word
                        </a>
                    </div>
                @endif

            @else
                <p class="text-gray-500 italic mt-2">No disponible</p>
            @endif
        </div>

    </div>


    {{-- RESUMEN DE ALUMNOS --}}
    <h2 class="text-xl font-semibold mb-3 text-gray-800">Resumen de alumnos</h2>

    <div class="flex gap-6 mb-6">
        <p><strong>Total:</strong> {{ $total }}</p>
        <p class="text-blue-600"><strong>Hombres:</strong> {{ $hombres }}</p>
        <p class="text-pink-600"><strong>Mujeres:</strong> {{ $mujeres }}</p>
    </div>

    {{-- LISTA DE ALUMNOS --}}
    <h2 class="text-xl font-semibold mb-3 text-gray-800">Lista de alumnos</h2>

    <table class="w-full border text-sm">
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


    {{-- REPORTES DE LA ASESORÍA --}}
    <h2 class="text-xl font-semibold mt-8 mb-4 text-gray-800">Reportes del Maestro</h2>

    @if($reports->isEmpty())
        <p class="text-gray-500 italic">No hay reportes disponibles.</p>
    @else
        <div class="space-y-4">
            @foreach($reports as $report)

                <div class="p-4 bg-gray-50 border rounded-lg shadow-sm">

                    <p class="font-semibold text-gray-700">
                        📄 Reporte {{ ucfirst($report->report_type) }}
                    </p>

                    @php
                        $path = asset('storage/' . $report->file_path);
                        $ext = strtolower(pathinfo($report->file_path, PATHINFO_EXTENSION));
                    @endphp

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
                            <img src="https://cdn-icons-png.flaticon.com/512/281/281760.png"
                                 class="w-10 h-10">
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

    {{-- BOTÓN VOLVER --}}
    <div class="mt-6">
        <a href="{{ route('basic_sciences.advisories.index') }}"
           class="text-green-700 hover:text-green-900 font-medium">
            ← Volver
        </a>
    </div>

</div>

</body>
</html>
