<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Asesoría</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.0/dist/cdn.min.js"></script>

</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
    <x-teachers-navbar/>
    <div class="flex-grow p-6">

<div class="max-w-3xl mx-auto bg-white shadow-lg rounded-xl p-8">

    {{-- Título --}}
    <h1 class="text-3xl font-bold text-gray-800 mb-6">📩 Solicitar Asesoría</h1>

    {{-- Formulario --}}
    <form action="{{ route('teachers.requests.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        {{-- Selección de alumnos --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Alumnos:</label>

            <select name="enrollments[]" multiple size="6"
                class="w-full border rounded-lg p-2 focus:ring-2 focus:ring-blue-500" required>
                @foreach($students as $s)
                    <option value="{{ $s->enrollment }}">
                        {{ $s->enrollment }} — {{ $s->name }} {{ $s->last_name_f }}
                    </option>
                @endforeach
            </select>

            <p class="text-blue-600 text-sm font-medium mt-1">
                * Mantén presionado CTRL para seleccionar varios alumnos
            </p>
        </div>

        {{-- Materia --}}
        {{-- Materia --}}
<div 
    x-data="{
        open: false,
        search: '',
        subjects: {{ json_encode($subjects) }},
        selectSubject(sub) {
            this.search = sub.name;
            document.getElementById('subject_id').value = sub.subject_id;
            this.open = false;
        }
    }" 
    class="relative"
>
    <label class="block text-sm font-semibold text-gray-700 mb-1">Materia:</label>

    <input type="text"
           x-model="search"
           x-on:input="open = true"
           placeholder="Escribe el nombre de la materia…"
           class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500">

    <input type="hidden" name="subject_id" id="subject_id" required>

    {{-- Caja de resultados --}}
    <div 
        x-show="open && search.length > 0"
        class="absolute bg-white w-full border rounded-lg mt-1 shadow-lg max-h-48 overflow-y-auto z-20"
    >
        <template 
            x-for="sub in subjects.filter(s => 
                s.name.toLowerCase().includes(search.toLowerCase())
            )" 
            :key="sub.subject_id"
        >
            <div class="p-2 hover:bg-gray-200 cursor-pointer text-sm"
                 x-on:click="selectSubject(sub)"
                 x-text="sub.name">
            </div>
        </template>

        {{-- Si no hay resultados --}}
        <div x-show="subjects.filter(s => s.name.toLowerCase().includes(search.toLowerCase())).length === 0"
             class="p-2 text-gray-500 text-sm">
             No se encontraron materias…
        </div>
    </div>

    @error('subject_id')
        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
    @enderror
</div>


        {{-- Motivo --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">Motivo / detalle de la asesoría:</label>

            <textarea name="reason" required rows="4"
                placeholder="Explica por qué solicitas esta asesoría"
                class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-500">{{ old('reason') }}</textarea>

            @error('reason')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Archivo --}}
        <div>
            <label class="block text-sm font-semibold text-gray-700 mb-1">
                Hoja de canalización (DOC/DOCX/PDF/JPG/PNG, máx. 2MB)
            </label>

            <input type="file" name="canalization_file" required accept=".pdf,.doc,.docx,.jpg,.jpeg,.png"
                class="w-full p-2 border rounded-lg bg-gray-50 focus:ring-2 focus:ring-blue-500">

            @error('canalization_file')
                <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        {{-- Botón --}}
        <div class="flex justify-end">
            <button type="submit"
                class="w-1/2 py-3 text-white font-bold rounded-lg shadow hover:opacity-90"
                        style="background-color:#28A745;">
                Enviar Solicitud
            </button>
        </div>

    </form>

</div>
</div>

<x-basic-sciences-footer />

</body>
</html>
