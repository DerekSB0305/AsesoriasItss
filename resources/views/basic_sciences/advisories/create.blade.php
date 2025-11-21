<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Asesoría</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen">

    <x-basic-sciences-navbar />

    <div class="max-w-4xl mx-auto bg-white mt-10 rounded-xl shadow p-8">

        <h1 class="text-3xl font-bold text-[#0B3D7E] mb-6">🧩 Crear Asesoría</h1>

        {{-- ERRORES --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded mb-6">
                <ul class="list-disc ml-6">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORMULARIO --}}
        <form action="{{ route('basic_sciences.advisories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- ID detalle --}}
            <input type="hidden" name="advisory_detail_id" value="{{ $detail->advisory_detail_id }}">

            {{-- Maestro - Materia --}}
            <div class="mb-5">
                <label class="font-semibold text-gray-700">Seleccione maestro y materia</label>
                <select name="teacher_subject_id" class="w-full border rounded-lg px-3 py-2 mt-1" required>
                    <option value="">-- Seleccione --</option>
                    @foreach ($teacherSubjects as $ts)
                        <option value="{{ $ts->teacher_subject_id }}">
                            {{ $ts->teacher->name }} {{ $ts->teacher->last_name_f }} —
                            {{ $ts->subject->name }} ({{ $ts->career->name }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- DÍA --}}
            <div class="mb-5">
                <label class="font-semibold text-gray-700">Día de la semana</label>
                <select name="day_of_week" class="w-full border rounded-lg px-3 py-2 mt-1" required>
                    <option value="">-- Seleccione --</option>
                    <option value="Lunes">Lunes</option>
                    <option value="Martes">Martes</option>
                    <option value="Miercoles">Miércoles</option>
                    <option value="Jueves">Jueves</option>
                    <option value="Viernes">Viernes</option>
                </select>
            </div>

            {{-- HORA INICIO --}}
            <div class="mb-5">
                <label class="font-semibold text-gray-700">Hora de inicio</label>
                <input type="time" name="start_time" class="w-full border rounded-lg px-3 py-2 mt-1" required>
                <p class="text-xs text-gray-500 mt-1">Horario permitido: 07:00 - 16:00</p>
            </div>

            {{-- HORA FIN --}}
            <div class="mb-5">
                <label class="font-semibold text-gray-700">Hora de fin</label>
                <input type="time" name="end_time" class="w-full border rounded-lg px-3 py-2 mt-1" required>
            </div>

            {{-- AULA --}}
            <div class="mb-5">
                <label class="font-semibold text-gray-700">Aula (opcional)</label>
                <input type="text" name="classroom" maxlength="10" class="w-full border rounded-lg px-3 py-2 mt-1">
            </div>

            {{-- EDIFICIO --}}
            <div class="mb-5">
                <label class="font-semibold text-gray-700">Edificio (opcional)</label>
                <input type="text" name="building" maxlength="10"
                       class="w-full border rounded-lg px-3 py-2 mt-1">
            </div>

            {{-- ARCHIVO --}}
            <div class="mb-5">
                <label class="font-semibold text-gray-700">Archivo de asignación (opcional)</label>
                <input type="file" name="assignment_file"
                       class="w-full border rounded-lg px-3 py-2 mt-1">
                <p class="text-xs text-gray-500">Formatos permitidos: PDF, DOCX, JPG, PNG</p>
            </div>

            {{-- BOTONES --}}
            <div class="flex justify-between mt-8">
                <a href="{{ route('basic_sciences.advisories.index') }}"
                   class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition">
                    Cancelar
                </a>

                <button class="px-6 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition">
                    Guardar Asesoría
                </button>
            </div>

        </form>

    </div>

    <x-basic-sciences-footer />

</body>
</html>

