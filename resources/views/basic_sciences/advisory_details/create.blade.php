<!DOCTYPE html> 
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Detalle de Asesoría</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen p-8 flex justify-center">

<div class="max-w-3xl w-full bg-white shadow-xl rounded-xl p-8">

    {{-- Título --}}
    <h1 class="text-3xl font-bold text-gray-800 mb-6">📄 Registrar Detalle de Asesoría</h1>

    {{-- Mensajes --}}
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
                {{-- Materia fija --}}
                <input type="hidden" name="subject_id" value="{{ $subjectId }}">
                <input type="text"
                       value="{{ $subjects->firstWhere('subject_id', $subjectId)->name }}"
                       class="w-full p-3 border rounded-lg bg-gray-100 text-gray-700 font-semibold shadow-sm"
                       readonly>
            @else
                {{-- Selección manual --}}
                <select id="subject_id" name="subject_id"
                        class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-green-500"
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
                    class="w-full p-3 border rounded-lg shadow-sm h-48 focus:ring-2 focus:ring-green-500"
                    required>
                <option value="">Seleccione una materia primero</option>
            </select>

            <p class="mt-2 text-sm text-red-600 font-semibold">
                * Mantén presionado <span class="underline">CTRL</span> (o <span class="underline">CMD</span> en Mac) para seleccionar varios.
            </p>
        </div>

        {{-- OBSERVACIONES --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Observaciones:</label>
            <textarea name="observations" rows="3"
                      class="w-full p-3 border rounded-lg shadow-sm focus:ring-2 focus:ring-green-500"></textarea>
        </div>

        {{-- BOTÓN --}}
        <div class="flex justify-end">
            <button type="submit"
                    class="px-6 py-3 text-white font-bold rounded-lg shadow hover:opacity-90 transition"
                    style="background-color:#28A745;">
                Guardar y continuar
            </button>
        </div>
    </form>
</div>

<script>
    function loadStudents(subjectId) {
        const studentsSelect = document.getElementById('students');

        studentsSelect.innerHTML = '<option value="">Cargando alumnos...</option>';

        fetch(`/basic_sciences/advisory_details/students/${subjectId}`)
            .then(r => r.json())
            .then(data => {
                studentsSelect.innerHTML = '';

                if (!data.length) {
                    studentsSelect.innerHTML = '<option value="">No hay solicitudes para esta materia</option>';
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
