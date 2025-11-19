<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Asesoría</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- NAVBAR --}}
    <x-basic-sciences-navbar />

    <div class="max-w-5xl mx-auto bg-white shadow-xl rounded-xl mt-10 p-8">

        {{-- TÍTULO --}}
        <h1 class="text-3xl font-extrabold text-[#0B3D7E] mb-6">
            ➕ Crear Asesoría
        </h1>

        {{-- ERRORES --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 rounded-lg p-4 mb-6">
                <strong class="block mb-2">⚠ Se encontraron errores:</strong>
                <ul class="list-disc list-inside text-sm">
                    @foreach ($errors->all() as $error)
                        <li>• {{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- LISTA DE ALUMNOS --}}
        <div class="mb-8">
            <h2 class="text-xl font-semibold text-gray-700 mb-3">👥 Alumnos incluidos</h2>

            <ul class="bg-gray-50 border border-gray-200 rounded-lg p-4 text-gray-800 text-sm shadow-sm">
                @foreach($detail->students as $stu)
                    <li class="border-b last:border-0 py-2">
                        <strong>{{ $stu->enrollment }}</strong> — 
                        {{ $stu->name }} {{ $stu->last_name_f }}
                    </li>
                @endforeach
            </ul>
        </div>

        {{-- FORMULARIO --}}
        <form method="POST"
              action="{{ route('basic_sciences.advisories.store') }}"
              enctype="multipart/form-data"
              class="grid grid-cols-1 md:grid-cols-2 gap-6">

            @csrf

            <input type="hidden" name="advisory_detail_id" value="{{ $detail->advisory_detail_id }}">

            {{-- MAESTRO – MATERIA – CARRERA --}}
            <div class="md:col-span-2">
                <label class="font-semibold text-gray-700 block mb-1">
                    Maestro - Materia - Carrera
                </label>
                <select name="teacher_subject_id"
                        class="w-full border rounded-lg p-3 shadow-sm focus:ring-2 focus:ring-[#0B3D7E]">
                    <option value="">Seleccione una opción</option>
                    @foreach($teacherSubjects as $ts)
                        <option value="{{ $ts->teacher_subject_id }}">
                            {{ $ts->teacher->name }} — 
                            {{ $ts->subject->name }} — 
                            {{ $ts->career->name }}
                        </option>
                    @endforeach
                </select>

                @error('teacher_subject_id')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- FECHA / HORA --}}
            <div>
                <label class="font-semibold text-gray-700 block mb-1">
                    Fecha y hora
                </label>

                <input type="datetime-local"
                       id="schedule"
                       name="schedule"
                       value="{{ old('schedule') }}"
                       class="w-full border rounded-lg p-3 shadow-sm focus:ring-2 focus:ring-[#0B3D7E]">

                {{-- ADVERTENCIA VISUAL --}}
                <p id="scheduleWarning"
                   class="hidden mt-2 text-red-700 font-semibold bg-red-100 border border-red-300 rounded-lg p-2">
                    ❌ La fecha seleccionada no es válida.<br>
                    ▪ Solo se permiten horarios entre <strong>6:00 AM y 6:00 PM</strong>.<br>
                    ▪ Los días <strong>SÁBADO</strong> y <strong>DOMINGO</strong> no están permitidos.
                </p>

                @error('schedule')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- EDIFICIO --}}
            <div>
                <label class="font-semibold text-gray-700 block mb-1">Edificio</label>
                <input type="text" name="building" maxlength="10"
                       value="{{ old('building') }}"
                       class="w-full border rounded-lg p-3 shadow-sm focus:ring-2 focus:ring-[#0B3D7E]">

                @error('building')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- AULA --}}
            <div>
                <label class="font-semibold text-gray-700 block mb-1">Aula</label>
                <input type="text" name="classroom" maxlength="10"
                       value="{{ old('classroom') }}"
                       class="w-full border rounded-lg p-3 shadow-sm focus:ring-2 focus:ring-[#0B3D7E]">

                @error('classroom')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- ARCHIVO --}}
            <div class="md:col-span-2">
                <label class="font-semibold text-gray-700 block mb-1">
                    Archivo de evidencia / tarea
                </label>

                <input type="file" name="assignment_file"
                       accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                       class="block w-full p-2 border rounded-lg shadow-sm bg-gray-50">

                @error('assignment_file')
                    <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                @enderror
            </div>

            {{-- BOTONES --}}
            <div class="md:col-span-2 flex justify-between mt-6">

                <a href="{{ route('basic_sciences.advisory_details.index') }}"
                   class="px-5 py-3 bg-gray-600 text-white rounded-lg font-semibold hover:bg-gray-700 transition">
                    ← Cancelar
                </a>

                <button id="submitBtn" type="submit"
                        class="px-6 py-3 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 shadow transition">
                    Guardar Asesoría
                </button>

            </div>

        </form>

    </div>

    {{-- FOOTER --}}
    <x-basic-sciences-footer />


    {{-- VALIDACIÓN HORARIOS EN TIEMPO REAL --}}
    <script>
        const scheduleInput = document.getElementById("schedule");
        const warning = document.getElementById("scheduleWarning");
        const submitBtn = document.getElementById("submitBtn");

        function validarFecha() {
            const value = scheduleInput.value;

            if (!value) {
                warning.classList.add("hidden");
                submitBtn.disabled = false;
                submitBtn.classList.remove("opacity-50", "cursor-not-allowed");
                return;
            }

            const date = new Date(value);
            const day = date.getDay(); // 0=Domingo, 6=Sábado
            const hour = date.getHours();

            let invalido = false;

            // Día inválido
            if (day === 0 || day === 6) invalido = true;

            // Hora inválida
            if (hour < 6 || hour > 18) invalido = true;

            if (invalido) {
                warning.classList.remove("hidden");
                submitBtn.disabled = true;
                submitBtn.classList.add("opacity-50", "cursor-not-allowed");
            } else {
                warning.classList.add("hidden");
                submitBtn.disabled = false;
                submitBtn.classList.remove("opacity-50", "cursor-not-allowed");
            }
        }

        scheduleInput.addEventListener("change", validarFecha);
        scheduleInput.addEventListener("input", validarFecha);
        validarFecha();
    </script>

</body>
</html>
