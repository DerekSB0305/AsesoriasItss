<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar Maestro a Materias</title>
    @vite('resources/css/app.css')

    <!-- Alpine.js -->
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="bg-gray-100 min-h-screen p-6">

<div class="max-w-5xl mx-auto bg-white shadow-md rounded-xl p-8">

    <h1 class="text-3xl font-bold text-gray-800 mb-6">➕ Asignar Maestro a Materias</h1>

    <form action="{{ route('basic_sciences.teacher_subjects.store') }}" method="POST">
        @csrf


        <!-- 🔵 BUSCADOR DE MAESTRO -->
        <div x-data="{ search: '', open: false }" class="mb-6 relative">
            <label class="block font-semibold mb-1">Maestro:</label>

            <input 
                type="text"
                x-model="search"
                x-on:input="open = true"
                placeholder="Escribe el nombre del maestro..."
                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-blue-500"
            >

            <!-- Campo oculto que envía el maestro seleccionado -->
            <input type="hidden" name="teacher_user" id="teacher_user">

            <!-- Resultados -->
            <ul 
                x-show="open && search.length > 0"
                class="absolute bg-white border rounded-lg mt-1 w-full shadow z-10 max-h-60 overflow-y-auto"
            >
                @foreach($teachers as $t)
                    <li 
                        class="px-4 py-2 hover:bg-blue-100 cursor-pointer"
                        x-show="'{{ strtolower($t->name) }}'.includes(search.toLowerCase())"
                        x-on:click="
                            search = '{{ $t->name }} {{ $t->last_name_f }} {{ $t->last_name_m }}';
                            document.getElementById('teacher_user').value = '{{ $t->teacher_user }}';
                            open = false;
                        "
                    >
                        {{ $t->name }} {{ $t->last_name_f }} {{ $t->last_name_m }}
                    </li>
                @endforeach
            </ul>
        </div>


        <!-- 🟣 BUSCADOR DE MATERIAS -->
        <div x-data="{ 
            materia: '', 
            showList: false 
        }">

            <label class="block font-semibold mb-2">Materias:</label>

            <input 
                type="text"
                x-model="materia"
                placeholder="Busca una materia..."
                x-on:input="showList = true"
                class="w-full border rounded-lg px-4 py-2 focus:ring-2 focus:ring-purple-500"
            >

            <div 
                x-show="showList && materia.length > 0"
                class="border bg-white rounded-lg shadow mt-1 max-h-64 overflow-y-auto"
            >
                @foreach($subjects as $subject)
                    <div 
                        class="px-4 py-2 hover:bg-purple-100 cursor-pointer"
                        x-show="'{{ strtolower($subject->name) }}'.includes(materia.toLowerCase())"
                        x-on:click="
                            materia = '';
                            showList = false;
                            $refs.subjectList.insertAdjacentHTML('beforeend', `
                                <div class='flex items-center gap-4 p-3 border rounded-lg bg-gray-50 my-2'>
                                    <input type='hidden' 
                                           name='subjects[{{ $subject->subject_id }}][subject_id]' 
                                           value='{{ $subject->subject_id }}'>
                                    <span class='font-semibold w-48'>{{ $subject->name }}</span>

                                    <select name='subjects[{{ $subject->subject_id }}][career_id]'
                                            class='border rounded px-2 py-1'>
                                        @foreach($careers as $career)
                                            <option value='{{ $career->career_id }}'>{{ $career->name }}</option>
                                        @endforeach
                                    </select>

                                    <button type='button' 
                                            class='text-red-600 hover:text-red-900 font-bold'
                                            onclick='this.parentNode.remove()'>
                                        ✖
                                    </button>
                                </div>
                            `);
                        "
                    >
                        {{ $subject->name }}
                    </div>
                @endforeach
            </div>

            <!-- Contenedor donde se agregan las materias seleccionadas -->
            <div class="mt-4" x-ref="subjectList"></div>

        </div>

        <br>

        <button 
            type="submit"
            class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 transition">
            Guardar asignación
        </button>

    </form>
</div>

</body>
</html>
