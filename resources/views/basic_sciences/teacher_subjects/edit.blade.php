<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Asignación</title>
    @vite('resources/css/app.css')
    <script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <x-basic-sciences-navbar />

<main class="flex-grow">

    <div class="w-full mx-auto bg-white shadow-lg rounded-lg p-6 sm:p-8 mt-8 mb-12
                max-w-md sm:max-w-lg md:max-w-2xl lg:max-w-4xl">

        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mb-6 flex items-center gap-2">
            ✏ Editar Asignación
        </h1>

        <form action="{{ route('basic_sciences.teacher_subjects.update', $teacherSubject->teacher_subject_id) }}" 
              method="POST">
            @csrf
            @method('PUT')

            <div class="mb-6">
                <label class="font-semibold block mb-1 text-[#0B3D7E]">Maestro:</label>

                <div class="w-full bg-gray-200 border border-gray-300 rounded-lg px-4 py-2 text-gray-700">
                    {{ $teacherSubject->teacher->name }} 
                    {{ $teacherSubject->teacher->last_name_f }} 
                    {{ $teacherSubject->teacher->last_name_m }}
                </div>

                <input type="hidden" 
                       name="teacher_user" 
                       value="{{ $teacherSubject->teacher_user }}">
            </div>

            <div class="mb-6 relative"
                 x-data="{ search:'', open:false }">

                <label class="font-semibold block mb-1 text-[#0B3D7E]">Materia:</label>

                <input type="text"
                       x-model="search"
                       x-on:input="open = true"
                       placeholder="Buscar materia..."
                       class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-indigo-500">

                <input type="hidden" 
                       name="subject_id" 
                       id="subject_id" 
                       value="{{ $teacherSubject->subject_id }}">

                <ul x-show="open && search.length > 0"
                    class="absolute bg-white border rounded-lg w-full shadow mt-1 max-h-48 overflow-y-auto z-20">

                    @foreach($subjects as $subject)
                        <li x-show="'{{ strtolower($subject->name) }}'.includes(search.toLowerCase())"
                            class="px-4 py-2 text-sm hover:bg-indigo-100 cursor-pointer"
                            x-on:click="
                                search = '{{ $subject->name }}';
                                document.getElementById('subject_id').value = '{{ $subject->subject_id }}';
                                open = false;
                            ">
                            {{ $subject->name }}
                        </li>
                    @endforeach
                </ul>

                <p class="text-sm text-gray-600 mt-2">
                    Seleccionada actualmente: 
                    <strong>{{ $teacherSubject->subject->name }}</strong>
                </p>
            </div>

            <div class="mb-6">
                <label class="font-semibold block mb-1 text-[#0B3D7E]">Carrera:</label>

                <select name="career_id"
                        class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-green-500">
                    @foreach($careers as $career)
                        <option value="{{ $career->career_id }}"
                            {{ $career->career_id == $teacherSubject->career_id ? 'selected' : '' }}>
                            {{ $career->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="flex flex-col sm:flex-row gap-4 mt-6">

                <a href="{{ route('basic_sciences.teacher_subjects.index') }}"
                   class="flex-1 py-3 text-center bg-gray-500 text-white font-bold rounded-lg shadow hover:bg-gray-600">
                    ← Cancelar
                </a>

                <button type="submit"
                        class="flex-1 py-3 bg-green-600 text-white font-bold rounded-lg shadow hover:bg-green-700">
                    Guardar cambios
                </button>

            </div>

        </form>

    </div>

</main>

<x-basic-sciences-footer />

</body>
</html>



