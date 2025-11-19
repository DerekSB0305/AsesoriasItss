<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Detalle de Asesoría</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    {{-- NAVBAR --}}
    <x-basic-sciences-navbar />

    <div class="max-w-3xl w-full mx-auto bg-white shadow-xl rounded-xl p-8 mt-10">

        {{-- TÍTULO --}}
        <h1 class="text-3xl font-extrabold text-[#0B3D7E] mb-6 flex items-center gap-2">
            📄 Registrar Detalle de Asesoría
        </h1>

        {{-- MENSAJES --}}
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

        {{-- FORMULARIO --}}
        <form method="POST" action="{{ route('basic_sciences.advisory_details.store') }}" class="space-y-6">
            @csrf

            {{-- MATERIA --}}
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

            {{-- ALUMNOS --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Alumnos:</label>

                <select id="students" name="request_id[]" multiple
                    class="w-full p-3 border rounded-lg shadow-sm h-48 focus:ring-2 focus:ring-green-600"
                    required>
                    <option value="">Seleccione una materia primero</option>
                </select>

                <p class="mt-2 text-sm text-gray-600 font-medium">
                    * Mantén presionado <span class="underline">CTRL</span> (o <span class="underline">CMD</span> en Mac) para seleccionar varios.
                </p>
            </div>

            {{-- OBSERVACIONES --}}
            <div>
                <label class="block text-sm font-semibold text-gray-700 mb-1">Observaciones:</label>
                <textarea name="observations" rows="3"
                    class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-green-600"></textarea>
            </div>

            {{-- BOTONES --}}
            <div class="flex justify-end gap-3">

                <a href="{{ route('basic_sciences.advisory_details.index') }}"
                   class="px-5 py-3 bg-gray-600 text-white font-semibold rounded-lg shadow hover:bg-gray-700 transition">
                   Cancelar
                </a>

                <button type="submit"
                    class="px-6 py-3 text-white font-bold rounded-lg shadow hover:bg-green-700 transition"
                    style="background-color:#28A745;">
                    Guardar y continuar
                </button>

            </div>
        </form>
    </div>

    {{-- FOOTER --}}
    <x-basic-sciences-footer />

<script>
    function loadStudents(subjectId) {
        const studentsSelect = document.getElementById('students');
        studentsSelect.innerHTML = '<option value="">Cargando alumnos...</option>';

        fetch(`/basic_sciences/advisory_details/students/${subjectId}`)
            .then(r => r.json())
            .then(data => {
                studentsSelect.innerHTML = '';

                if (!data.length) {
                    studentsSelect.innerHTML =
                        '<option value="">No hay solicitudes disponibles para esta materia</option>';
                    return;
                }

                data.forEach(item => {
                    const opt = document.createElement('option');
                    opt.value = item.request_id;
                    opt.textContent = `${item.enrollment} — ${item.name} ${item.last_name_f}`;
                    studentsSelect.appendChild(opt);
                });
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

