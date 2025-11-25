<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Asesoría</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen">

<x-basic-sciences-navbar />

<main class="flex-grow">

<div class="max-w-4xl mx-auto bg-white mt-8 p-8 rounded-xl shadow">

    <h1 class="text-3xl font-bold text-[#0B3D7E] mb-6">➕ Crear Asesoría</h1>

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

    {{-- INFO ALUMNOS --}}
    <div class="bg-blue-50 border border-blue-300 p-4 rounded mb-6">
        <h3 class="font-semibold text-blue-900 mb-2">👥 Esta asesoría será asignada a:</h3>

        <ul class="list-disc ml-6 text-blue-800">
            @foreach ($detail->students as $s)
                <li>{{ $s->enrollment }} — {{ $s->name }} {{ $s->last_name_f }}</li>
            @endforeach
        </ul>
    </div>

    <form action="{{ route('basic_sciences.advisories.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <input type="hidden" name="advisory_detail_id" value="{{ $detail->advisory_detail_id }}">

        {{-- Maestro / materia --}}
        <div class="mb-5">
            <label class="font-semibold">Maestro y materia</label>
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

        {{-- Fechas --}}
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="font-semibold">Fecha inicio</label>
                <input type="date" name="start_date"
                       min="{{ date('Y-m-d') }}"
                       class="w-full border rounded-lg px-3 py-2"
                       required>
            </div>

            <div>
                <label class="font-semibold">Fecha fin</label>
                <input type="date" name="end_date"
                       min="{{ date('Y-m-d') }}"
                       class="w-full border rounded-lg px-3 py-2"
                       required>
            </div>
        </div>

        {{-- Día --}}
        <div class="mt-5">
            <label class="font-semibold">Día de la semana</label>
            <select name="day_of_week" class="w-full border rounded-lg px-3 py-2 mt-1" required>
                <option value="">-- Seleccione --</option>
                <option>Lunes</option>
                <option>Martes</option>
                <option>Miercoles</option>
                <option>Jueves</option>
                <option>Viernes</option>
            </select>
        </div>

        {{-- Horas --}}
        <div class="grid grid-cols-2 gap-4 mt-5">
            <div>
                <label class="font-semibold">Hora inicio</label>
                <input type="time" name="start_time" class="w-full border rounded-lg px-3 py-2" required>
                <p class="text-xs text-gray-500">Permitido: 07:00 – 16:00</p>
            </div>

            <div>
                <label class="font-semibold">Hora fin</label>
                <input type="time" name="end_time" class="w-full border rounded-lg px-3 py-2" required>
            </div>
        </div>

        {{-- Aula --}}
        <div class="mt-5">
            <label class="font-semibold">Aula</label>
            <input type="text" name="classroom" maxlength="10" class="w-full border rounded-lg px-3 py-2">
        </div>

        {{-- Edificio --}}
        <div class="mt-5">
            <label class="font-semibold">Edificio</label>
            <input type="text" name="building" maxlength="10" class="w-full border rounded-lg px-3 py-2">
        </div>

        {{-- Archivo --}}
        <div class="mt-5">
            <label class="font-semibold">Archivo de asignación (opcional)</label>
            <input type="file" name="assignment_file" class="w-full border rounded-lg px-3 py-2">
        </div>

        {{-- Botones --}}
        <div class="flex justify-between mt-8">
            <a href="{{ route('basic_sciences.advisories.index') }}"
               class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                Cancelar
            </a>

            <button class="px-6 py-2 bg-[#28A745] text-white rounded-lg hover:bg-green-700">
                Guardar asesoría
            </button>
        </div>

    </form>
</div>

</main>

<x-basic-sciences-footer />

</body>
</html>
