<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

        <form method="POST" action="{{ route('basic_sciences.advisory_details.store') }}" class="space-y-6">
            @csrf

            {{-- Materia --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Materia:</label>
                <select id="subject_id" name="subject_id" 
                        class="w-full border-gray-300 rounded-md p-2 shadow-sm focus:ring-green-500 focus:border-green-500">
                    <option value="">Seleccione una materia</option>
                    @foreach($subjects as $subject)
                        <option value="{{ $subject->subject_id }}">{{ $subject->name }}</option>
                    @endforeach
                </select>
            </div>

            {{-- Alumnos (MULTIPLE) --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Alumnos:</label>

                <select id="students" name="request_id[]" MULTIPLE size="6"
                        class="w-full border-gray-300 rounded-md p-2 shadow-sm focus:ring-green-500 focus:border-green-500" required>
                    <option value="">Seleccione una materia primero</option>
                </select>
                <div class="bg-blue-100 border-l-4 border-blue-500 text-blue-700 p-2 mt-2 rounded">
                    ⚠️ <strong>Use CTRL + clic</strong> para seleccionar varios alumnos
                </div>




            </div>

            {{-- Observaciones --}}
            <div>
                <label class="block text-sm font-medium text-gray-700">Observaciones:</label>
                <textarea name="observations" rows="3"
                          class="w-full border-gray-300 rounded-md p-2 shadow-sm focus:ring-green-500 focus:border-green-500"></textarea>
            </div>

            <div class="flex justify-end">
                <button type="submit"
                        class="bg-green-600 text-white px-4 py-2 rounded-md hover:bg-green-700 transition">
                    Guardar y Continuar
                </button>
            </div>
        </form>
    </div>

    {{-- Script dinámico --}}
    <script>
        document.getElementById('subject_id').addEventListener('change', function () {
            const subjectId = this.value;
            const studentsSelect = document.getElementById('students');

            studentsSelect.innerHTML = '<option>Cargando alumnos...</option>';

            if (subjectId) {
                fetch(`/basic_sciences/advisory_details/students/${subjectId}`)
                    .then(response => response.json())
                    .then(data => {
                        studentsSelect.innerHTML = '';

                        if (data.error) {
                            studentsSelect.innerHTML = `<option value="">${data.error}</option>`;
                            return;
                        }

                        data.forEach(student => {
                            const option = document.createElement('option');
                            option.value = student.request_id; 
                            option.textContent = `${student.name} (${student.enrollment})`;
                            studentsSelect.appendChild(option);
                        });
                    })
                    .catch(() => {
                        studentsSelect.innerHTML = '<option>Error al cargar alumnos</option>';
                    });
            } else {
                studentsSelect.innerHTML = '<option>Seleccione una materia primero</option>';
            }
        });
    </script>
</body>
</html>
