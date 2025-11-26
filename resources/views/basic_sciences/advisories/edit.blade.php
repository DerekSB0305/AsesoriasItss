<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Asesoría</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <div class="fixed top-0 left-0 w-full z-50 shadow">
        <x-basic-sciences-navbar />
    </div>

    <main class="flex-grow mt-28 mb-20 px-4">

        <div class="max-w-4xl mx-auto bg-white shadow-xl rounded-xl p-6 sm:p-8">

            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0B3D7E] mb-6">
                ✏️ Editar Asesoría
            </h1>

            @if ($errors->any())
                <div class="bg-red-100 border border-red-400 text-red-700 rounded-lg p-4 mb-6">
                    <strong class="block mb-2">⚠ Errores detectados:</strong>
                    <ul class="list-disc ml-6 text-sm">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('basic_sciences.advisories.update', $advisory->advisory_id) }}"
                method="POST" enctype="multipart/form-data">

                @csrf
                @method('PUT')

                <div class="bg-gray-50 border p-4 rounded-lg mb-6 text-sm sm:text-base">
                    <p><strong>Maestro:</strong> {{ $advisory->teacherSubject->teacher->name }} {{ $advisory->teacherSubject->teacher->last_name_f }}</p>
                    <p><strong>Materia:</strong> {{ $advisory->teacherSubject->subject->name }}</p>
                    <p><strong>Carrera:</strong> {{ $advisory->teacherSubject->career->name }}</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                    <div>
                        <label class="font-semibold text-gray-700">Fecha inicio</label>
                        <input type="date" name="start_date"
                            value="{{ $advisory->start_date }}"
                            class="w-full border rounded-lg p-3 bg-gray-100"
                            readonly>
                    </div>

                    <div>
                        <label class="font-semibold text-gray-700">Fecha fin</label>
                        <input type="date" name="end_date"
                            value="{{ $advisory->end_date }}"
                            class="w-full border rounded-lg p-3">
                    </div>

                    <div>
                        <label class="font-semibold text-gray-700">Día de la semana</label>
                        <select name="day_of_week" class="w-full border rounded-lg p-3" required>
                            @foreach (['Lunes','Martes','Miércoles','Jueves','Viernes'] as $d)
                                <option value="{{ $d }}" {{ $advisory->day_of_week == $d ? 'selected' : '' }}>
                                    {{ $d }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label class="font-semibold text-gray-700 block mb-1">Hora inicio</label>
                        <input type="time" name="start_time"
                            value="{{ \Carbon\Carbon::createFromFormat('H:i:s', $advisory->start_time)->format('H:i') }}"
                            class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>

                    <div>
                        <label class="font-semibold text-gray-700 block mb-1">Hora fin</label>
                        <input type="time" name="end_time"
                            value="{{ \Carbon\Carbon::createFromFormat('H:i:s', $advisory->end_time)->format('H:i') }}"
                            class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-500"
                            required>
                    </div>

                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">

                    <div>
                        <label class="font-semibold">Aula</label>
                        <input type="text" name="classroom"
                            value="{{ $advisory->classroom }}"
                            class="w-full border rounded-lg p-3">
                    </div>

                    <div>
                        <label class="font-semibold">Edificio</label>
                        <input type="text" name="building"
                            value="{{ $advisory->building }}"
                            class="w-full border rounded-lg p-3">
                    </div>

                </div>

                <div class="mt-8">
                    <h3 class="font-semibold text-gray-700 mb-2">Alumnos asignados:</h3>

                    <ul class="list-disc ml-6 text-gray-700 bg-gray-50 border rounded-lg p-4 text-sm sm:text-base">
                        @foreach ($advisory->advisoryDetail->students as $s)
                            <li>{{ $s->enrollment }} — {{ $s->name }}</li>
                        @endforeach
                    </ul>
                </div>

                <div class="mt-6">
                    <label class="font-semibold text-gray-700 block mb-1">Archivo (opcional)</label>
                    <input type="file" name="assignment_file"
                        class="w-full border p-3 rounded-lg bg-white">
                </div>

                <div class="mt-8 flex flex-col sm:flex-row justify-between gap-3">

                    <a href="{{ route('basic_sciences.advisories.index') }}"
                    class="px-5 py-3 bg-gray-600 text-white rounded-lg hover:bg-gray-700 text-center">
                        ← Cancelar
                    </a>

                    <button
                        class="px-6 py-3 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 shadow text-center">
                        Guardar cambios
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

