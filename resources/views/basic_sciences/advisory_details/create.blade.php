<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Registrar Detalle de Asesoría</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 p-8">
<div class="max-w-3xl mx-auto bg-white shadow-lg rounded-lg p-6">
    <h1 class="text-2xl font-bold mb-4 text-gray-800">Registrar Detalle de Asesoría</h1>

    @if(session('success'))
        <div class="bg-green-100 text-green-800 border border-green-300 rounded-md p-3 mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="bg-red-100 text-red-800 border border-red-300 rounded-md p-3 mb-4">
            {{ session('error') }}
        </div>
    @endif

    <form method="POST" action="{{ route('basic_sciences.advisory_details.store') }}" class="space-y-6">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-700">Materia:</label>
            <select id="subject_id" name="subject_id"
                    class="w-full border-gray-300 rounded-md p-2 shadow-sm focus:ring-green-500 focus:border-green-500" required>
                <option value="">Seleccione una materia</option>
                @foreach($subjects as $subject)
                    <option value="{{ $subject->subject_id }}">{{ $subject->name }}</option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Alumnos:</label>
            <select id="students" name="request_id[]" multiple
                    class="w-full border-gray-300 rounded-md p-2 shadow-sm focus:ring-green-500 focus:border-green-500 h-40" required>
                <option value="">Seleccione una materia primero</option>
            </select>

            <p class="mt-2 text-xs font-semibold text-red-600">
                * Mantén presionada la tecla <span class="underline">CTRL</span> (o <span class="underline">CMD</span> en Mac) para seleccionar varios alumnos
            </p>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Observaciones:</label>
            <textarea name="observations" rows="3"
                      class="w-full border-gray-300 rounded-md p-2 shadow-sm focus:ring-green-500 focus:border-green-500"></textarea>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
                Guardar y continuar
            </button>
        </div>
    </form>
</div>

<script>
    document.getElementById('subject_id').addEventListener('change', function () {
        const subjectId = this.value;
        const studentsSelect = document.getElementById('students');

        studentsSelect.innerHTML = '<option value="">Cargando alumnos...</option>';

        if (subjectId) {
            fetch(`/basic_sciences/advisory_details/students/${subjectId}`)
                .then(response => {
                    if (!response.ok) throw new Error('Error al obtener los alumnos');
                    return response.json();
                })
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
                })
                .catch(error => {
                    console.error(error);
                    studentsSelect.innerHTML = '<option value="">Error al cargar alumnos</option>';
                });
        } else {
            studentsSelect.innerHTML = '<option value="">Seleccione una materia primero</option>';
        }
    });
</script>
</body>
</html>
