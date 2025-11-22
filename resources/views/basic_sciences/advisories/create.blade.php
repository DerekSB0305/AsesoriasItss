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

        <h1 class="text-3xl font-extrabold text-[#0B3D7E] mb-6">🧩 Crear Asesoría</h1>

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

        {{-- 🔵 INFORMACIÓN DE ALUMNOS --}}
        <div class="mb-8 bg-blue-50 border border-blue-200 rounded-xl p-4 shadow-sm">
            <h2 class="text-lg font-semibold text-blue-900 mb-2">👥 Alumnos incluidos en esta asesoría</h2>

            <ul class="list-disc ml-6 text-blue-800">
                @foreach ($detail->students as $student)
                    <li>
                        {{ $student->name }} {{ $student->last_name_f }} ({{ $student->enrollment }})
                    </li>
                @endforeach
            </ul>

            <p class="text-sm text-blue-700 mt-3">
                *Todos estos alumnos quedarán inscritos en la asesoría que estás creando.*
            </p>
        </div>

        {{-- FORMULARIO --}}
        <form action="{{ route('basic_sciences.advisories.store') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <input type="hidden" name="advisory_detail_id" value="{{ $detail->advisory_detail_id }}">

            {{-- Maestro - Materia --}}
            <div class="mb-5">
                <label class="font-semibold text-gray-700">Seleccione maestro y materia</label>
                <select name="teacher_subject_id" class="w-full border rounded-lg px-3 py-2 mt-1" required>
                    <option value="">-- Seleccione --</option>
                    @foreach ($teacherSubjects as $ts)
                        <option value="{{ $ts->teacher_subject_id }}">
                            {{ $ts->teacher->name }} {{ $ts->teacher->last_name_f }}
                            — {{ $ts->subject->name }} ({{ $ts->career->name }})
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- FECHA INICIO --}}
            <div class="mb-5">
                <label class="font-semibold text-gray-700">Fecha de inicio</label>
                <input type="date" name="start_date" class="w-full border rounded-lg px-3 py-2 mt-1" required>
            </div>

            {{-- FECHA FIN --}}
            <div class="mb-5">
                <label class="font-semibold text-gray-700">Fecha de fin</label>
                <input type="date" name="end_date" class="w-full border rounded-lg px-3 py-2 mt-1" required>
            </div>

            {{-- DÍA DE LA SEMANA --}}
            <div class="mb-5">
                <label class="font-semibold text-gray-700">Día de la semana</label>
                <select name="day_of_week" class="w-full border rounded-lg px-3 py-2 mt-1" required>
                    <option value="">-- Seleccione --</option>
                    <option value="Lunes">Lunes</option>
                    <option value="Martes">Martes</option>
                    <option value="Miércoles">Miércoles</option>
                    <option value="Jueves">Jueves</option>
                    <option value="Viernes">Viernes</option>
                </select>
            </div>

            {{-- HORA INICIO --}}
            <div class="mb-5">
                <label class="font-semibold text-gray-700">Hora inicio</label>
                <input type="time" name="start_time" class="w-full border rounded-lg px-3 py-2 mt-1" required>
            </div>

            {{-- HORA FIN --}}
            <div class="mb-5">
                <label class="font-semibold text-gray-700">Hora fin</label>
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
                <input type="text" name="building" maxlength="10" class="w-full border rounded-lg px-3 py-2 mt-1">
            </div>

            {{-- ARCHIVO --}}
            <div class="mb-5">
                <label class="font-semibold text-gray-700">Archivo de asignación (opcional)</label>
                <input type="file" name="assignment_file" class="w-full border rounded-lg px-3 py-2 mt-1">
                <p class="text-xs text-gray-500">Formatos: PDF, DOCX, JPG, PNG</p>
            </div>

            {{-- BOTONES --}}
            <div class="flex justify-between mt-8">
                <a href="{{ route('basic_sciences.advisories.index') }}"
                   class="px-4 py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 transition">
                    Cancelar
                </a>

                <button class="px-6 py-2 rounded-lg text-white shadow transition"
                        style="background-color: #28A745;">
                    Guardar Asesoría
                </button>
            </div>

        </form>

    </div>

    <x-basic-sciences-footer />

</body>
</html>
