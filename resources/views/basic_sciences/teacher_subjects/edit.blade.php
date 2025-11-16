<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Editar Asignación</title>
    @vite('resources/css/app.css')
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="bg-gray-100 min-h-screen p-6">

<div class="max-w-4xl mx-auto bg-white shadow-md rounded-xl p-8">

    <h1 class="text-3xl font-bold text-gray-800 mb-6">✏ Editar Asignación</h1>

    <form action="{{ route('basic_sciences.teacher_subjects.update', $teacherSubject->teacher_subject_id) }}" 
          method="POST">
        @csrf
        @method('PUT')

        <div class="mb-5">
            <label class="font-semibold block mb-1">Maestro:</label>
            <input 
                type="text"
                value="{{ $teacherSubject->teacher->name }} {{ $teacherSubject->teacher->last_name_f }} {{ $teacherSubject->teacher->last_name_m }}"
                disabled
                class="w-full bg-gray-200 border border-gray-300 rounded-lg px-4 py-2 text-gray-700"
            >

            
            <input type="hidden" name="teacher_user" value="{{ $teacherSubject->teacher_user }}">
        </div>

        
        <div class="mb-5" x-data="{ busqueda: '', abrir: false }">

            <label class="font-semibold block mb-1">Materia:</label>

            <input 
                type="text"
                x-model="busqueda"
                placeholder="Buscar materia..."
                x-on:input="abrir = true"
                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-indigo-500"
            >

            <input type="hidden" name="subject_id" id="subject_id" value="{{ $teacherSubject->subject_id }}">

            <ul 
                x-show="abrir && busqueda.length > 0"
                class="absolute bg-white border rounded-lg w-full shadow mt-1 max-h-60 overflow-y-auto z-10"
            >
                @foreach($subjects as $subject)
                    <li 
                        x-show="'{{ strtolower($subject->name) }}'.includes(busqueda.toLowerCase())"
                        class="px-4 py-2 hover:bg-indigo-100 cursor-pointer"
                        x-on:click="
                            busqueda = '{{ $subject->name }}';
                            document.getElementById('subject_id').value = '{{ $subject->subject_id }}';
                            abrir = false;
                        "
                    >
                        {{ $subject->name }}
                    </li>
                @endforeach
            </ul>

            <p class="text-sm text-gray-500 mt-1">
                Seleccionada: <strong>{{ $teacherSubject->subject->name }}</strong>
            </p>
        </div>

        
        <div class="mb-6">
            <label class="font-semibold block mb-1">Carrera:</label>

            <select name="career_id" 
                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-green-500">
                @foreach($careers as $career)
                    <option value="{{ $career->career_id }}"
                        {{ $career->career_id == $teacherSubject->career_id ? 'selected' : '' }}>
                        {{ $career->name }}
                    </option>
                @endforeach
            </select>
        </div>

        <button 
            type="submit"
            class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700 transition">
            Guardar Cambios
        </button>

    </form>

    <br>
    <a href="{{ route('basic_sciences.teacher_subjects.index') }}" 
       class="text-gray-600 hover:text-gray-800">
        ← Regresar
    </a>

</div>

</body>
</html>



