<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registrar Detalle de Asesoría</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <div class="fixed top-0 left-0 w-full z-50 shadow">
        <x-basic-sciences-navbar />
    </div>

    <main class="flex-1 mt-28 mb-10 px-4">

        <div class="max-w-3xl w-full mx-auto bg-white shadow-xl rounded-xl p-6 sm:p-8">

            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0B3D7E] mb-6 flex items-center gap-2">
                📄 Registrar Detalle de Asesoría
            </h1>

            @if(session('success'))
                <div class="bg-green-100 text-green-800 border border-green-300 rounded-md p-4 mb-4">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="bg-red-100 text-red-800 border border-red-300 rounded-md p-4 mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form method="POST"
                  action="{{ route('basic_sciences.advisory_details.store') }}"
                  class="space-y-6">
                @csrf

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Materia:</label>

                    @if(isset($subjectId))

                        <input type="hidden" name="subject_id" value="{{ $subjectId }}">

                        <input type="text"
                            value="{{ $subjects->firstWhere('subject_id', $subjectId)->name }}"
                            class="w-full p-3 border rounded-lg bg-gray-100 text-gray-700 font-semibold shadow-sm"
                            readonly>

                    @else

                        <select id="subject_id" name="subject_id"
                                class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-green-600"
                                required>
                            <option value="">Seleccione una materia</option>

                            @foreach($subjects as $subject)
                                <option value="{{ $subject->subject_id }}">{{ $subject->name }}</option>
                            @endforeach
                        </select>

                    @endif
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Alumnos disponibles:</label>

                    <select id="students" name="request_id[]" multiple
                        class="w-full p-3 border rounded-lg shadow-sm h-52 sm:h-64 focus:ring-2 focus:ring-green-600 text-sm"
                        required>
                        <option value="">Seleccione una materia primero</option>
                    </select>

                    <p class="mt-2 text-sm text-gray-600">
                        * Mantén presionado <span class="underline">CTRL</span> o <span class="underline">CMD</span>
                        para seleccionar varios.
                    </p>
                </div>

                <div id="repetidoresDiv" class="hidden mt-4 bg-yellow-50 border border-yellow-300 p-4 rounded-lg">
                    <p class="font-semibold text-yellow-700 text-sm sm:text-base">
                        ⚠ Alumnos que ya llevaron esta materia anteriormente:
                    </p>

                    <ul class="mt-2 space-y-1"></ul>
                </div>

                <div>
                    <label class="block text-sm font-semibold text-gray-700 mb-1">Observaciones:</label>
                    <textarea name="observations" rows="3"
                        class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-green-600"></textarea>
                </div>

                {{-- BOTONES --}}
                <div class="flex flex-col sm:flex-row justify-end gap-3">

                    <a href="{{ route('basic_sciences.advisories.index') }}"
                       class="px-5 py-3 bg-gray-600 text-white font-semibold rounded-lg shadow hover:bg-gray-700 text-center">
                       Cancelar
                    </a>

                    <button type="submit"
                        class="px-6 py-3 text-white font-bold rounded-lg shadow hover:bg-green-700"
                        style="background-color:#28A745;">
                        Guardar y continuar
                    </button>

                </div>

            </form>
        </div>

    </main>

    <div class="w-full mt-10">
        <x-basic-sciences-footer />
    </div>

    <script>
        function loadStudents(subjectId) {
            const studentsSelect = document.getElementById('students');
            const repetidoresDiv = document.getElementById('repetidoresDiv');
            const repetidoresList = repetidoresDiv.querySelector('ul');

            studentsSelect.innerHTML = '<option>Cargando alumnos...</option>';
            repetidoresList.innerHTML = '';
            repetidoresDiv.classList.add('hidden');

            fetch(`/basic_sciences/advisory_details/students/${subjectId}`)
                .then(r => r.json())
                .then(data => {

                    // Alumnos disponibles
                    studentsSelect.innerHTML = '';

                    if (!data.disponibles.length) {
                        studentsSelect.innerHTML =
                            '<option>No hay solicitudes disponibles para esta materia</option>';
                    } else {
                        data.disponibles.forEach(item => {
                            const opt = document.createElement('option');
                            opt.value = item.request_id;
                            opt.textContent = `${item.enrollment} — ${item.name} ${item.last_name_f} ${item.last_name_m}`;
                            studentsSelect.appendChild(opt);
                        });
                    }

                    // Alumnos repetidores
                    if (data.repetidores.length > 0) {
                        repetidoresDiv.classList.remove('hidden');

                        data.repetidores.forEach(stu => {
                            const li = document.createElement('li');
                            li.className = "text-sm text-yellow-700 font-medium";
                            li.innerHTML = `* ${stu.enrollment} — ${stu.name} ${stu.last_name_f} ${stu.last_name_m}`;
                            repetidoresList.appendChild(li);
                        });
                    }
                });
        }

        @if(isset($subjectId))
            loadStudents({{ $subjectId }});
        @else
            document.getElementById('subject_id').addEventListener('change', function () {
                loadStudents(this.value);
            });
        @endif
    </script>

</body>
</html>
