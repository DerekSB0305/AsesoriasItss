<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Asesoría</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <div class="fixed top-0 left-0 w-full z-50 shadow">
        <x-basic-sciences-navbar />
    </div>

    <main class="flex-1 mt-28 mb-10 px-4">

        <div class="max-w-4xl mx-auto bg-white p-6 sm:p-8 mt-4 rounded-xl shadow">

            <h1 class="text-2xl sm:text-3xl font-bold text-[#0B3D7E] mb-6">
                ➕ Crear Asesoría
            </h1>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded mb-6 text-sm">
                    <ul class="list-disc ml-6">
                        @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="bg-blue-50 border border-blue-300 p-4 rounded mb-6">
                <h3 class="font-semibold text-blue-900 mb-2 text-sm sm:text-base">👥 Esta asesoría será asignada a:</h3>

                <ul class="list-disc ml-6 text-blue-800 text-sm">
                    @foreach ($detail->students as $s)
                        <li>{{ $s->enrollment }} — {{ $s->name }} {{ $s->last_name_f }}</li>
                    @endforeach
                </ul>
            </div>

            <form action="{{ route('basic_sciences.advisories.store') }}" 
                  method="POST" 
                  enctype="multipart/form-data"
                  class="space-y-6">
                @csrf

                <input type="hidden" name="advisory_detail_id" value="{{ $detail->advisory_detail_id }}">

                <div>
                    <label class="font-semibold text-sm">Maestro y materia</label>
                    <select name="teacher_subject_id"
                            class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-600"
                            required>
                        <option value="">-- Seleccione --</option>
                        @foreach ($teacherSubjects as $ts)
                            <option value="{{ $ts->teacher_subject_id }}">
                                {{ $ts->teacher->name }} {{ $ts->teacher->last_name_f }} — 
                                {{ $ts->subject->name }} ({{ $ts->career->name }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="font-semibold text-sm">Fecha inicio</label>
                        <input type="date" name="start_date"
                               min="{{ date('Y-m-d') }}"
                               class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-600"
                               required>
                    </div>

                    <div>
                        <label class="font-semibold text-sm">Fecha fin</label>
                        <input type="date" name="end_date"
                               min="{{ date('Y-m-d') }}"
                               class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-600"
                               required>
                    </div>
                </div>

                <div>
                    <label class="font-semibold text-sm">Día de la semana</label>
                    <select name="day_of_week"
                            class="w-full border rounded-lg px-3 py-2 mt-1 focus:ring-2 focus:ring-blue-600"
                            required>
                        <option value="">-- Seleccione --</option>
                        <option>Lunes</option>
                        <option>Martes</option>
                        <option>Miercoles</option>
                        <option>Jueves</option>
                        <option>Viernes</option>
                    </select>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label class="font-semibold text-sm">Hora inicio</label>
                        <input type="time" name="start_time"
                               class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-600"
                               required>
                        <p class="text-xs text-gray-500 mt-1">Permitido: 07:00 – 16:00</p>
                    </div>

                    <div>
                        <label class="font-semibold text-sm">Hora fin</label>
                        <input type="time" name="end_time"
                               class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-600"
                               required>
                    </div>
                </div>

                <div>
                    <label class="font-semibold text-sm">Aula</label>
                    <input type="text" name="classroom"
                           maxlength="10"
                           class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-600">
                </div>

                <div>
                    <label class="font-semibold text-sm">Edificio</label>
                    <input type="text" name="building"
                           maxlength="10"
                           class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-600">
                </div>

                <div>
                    <label class="font-semibold text-sm">Archivo de asignación (opcional)</label>
                    <input type="file" name="assignment_file"
                           class="w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-600">
                </div>

                <div class="flex flex-col sm:flex-row justify-between gap-3">

                    <button class="px-6 py-3 bg-[#28A745] text-white rounded-lg hover:bg-green-700 font-semibold">
                        Guardar asesoría
                    </button>

                </div>
            </form>

        </div>

    </main>

    <div class="w-full mt-10">
        <x-basic-sciences-footer />
    </div>

</body>
</html>
