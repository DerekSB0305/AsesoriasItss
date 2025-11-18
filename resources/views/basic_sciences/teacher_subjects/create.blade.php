<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asignar Materias a Maestro</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.0/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 min-h-screen p-6">

<div class="max-w-4xl mx-auto bg-white shadow-xl rounded-xl p-8">

    <h1 class="text-3xl font-bold text-gray-800 mb-6">
        📘 Asignar Materias a Maestro (Ciencias Básicas)
    </h1>

   @if ($errors->any())
        <div class="bg-red-100 border border-red-300 text-red-700 p-4 rounded-lg mb-4">
            <strong class="block mb-2">⚠️ Se encontraron errores:</strong>
            <ul class="list-disc ml-6">
            @foreach ($errors->all() as $e)
                <li>{{ $e }}</li>
            @endforeach
        </ul>
    </div>
    @endif


    <form action="{{ route('basic_sciences.teacher_subjects.store') }}" method="POST">
        @csrf

        {{--  BUSCADOR DE MAESTRO --}}
        <div x-data="{
                open: false,
                search: '',
                teachers: {{ json_encode($teachers) }},
                selectTeacher(t) {
                    this.search = `${t.name} ${t.last_name_f} ${t.last_name_m}`;
                    document.getElementById('teacher_user').value = t.teacher_user;
                    this.open = false;
                }
            }" class="relative mb-6">

            <label class="font-semibold block mb-2">Buscar maestro:</label>

            <input type="text" x-model="search"
                   x-on:input="open = true"
                   placeholder="Escribe el nombre del maestro…"
                   class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-blue-300">

            <input type="hidden" name="teacher_user" id="teacher_user" required>

            {{-- dropdown --}}
            <div x-show="open && search.length > 0"
                 class="absolute bg-white border rounded-lg w-full mt-1 shadow-lg max-h-48 overflow-y-auto z-20">

                <template x-for="t in teachers.filter(te =>
                    (`${te.name} ${te.last_name_f} ${te.last_name_m}`)
                    .toLowerCase()
                    .includes(search.toLowerCase())
                )">
                    <div class="p-2 hover:bg-gray-200 cursor-pointer"
                         x-on:click="selectTeacher(t)"
                         x-text="`${t.name} ${t.last_name_f} ${t.last_name_m}`">
                    </div>
                </template>

            </div>

        </div>

        {{--  MATERIAS DINÁMICAS --}}
        <div x-data="{
                rows: [{ id: Date.now() }],
                addRow() { this.rows.push({ id: Date.now() + Math.random() }) },
                removeRow(i) { if (this.rows.length > 1) this.rows.splice(i, 1) }
            }">

            <h2 class="text-xl font-semibold mb-4">Materias asignadas</h2>

            <template x-for="(row, index) in rows" :key="row.id">

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-4 p-4 bg-gray-50 border rounded-lg">

                    {{-- BUSCADOR DE MATERIA --}}
                    <div x-data="{
                            open: false,
                            search: '',
                            subjects: {{ json_encode($subjects) }},
                            selectSubject(subj) {
                                this.search = subj.name;
                                document.getElementById('subject_' + row.id).value = subj.subject_id;
                                this.open = false;
                            }
                        }" class="relative">

                        <label class="font-semibold block mb-1">Buscar materia:</label>

                        <input type="text"
                               x-model="search"
                               x-on:input="open = true"
                               placeholder="Escribe la materia…"
                               class="w-full p-2 border rounded-lg focus:ring-2 focus:ring-blue-300">

                        <input type="hidden"
                               :id="`subject_${row.id}`"
                               :name="`subjects[${row.id}][subject_id]`"
                               required>

                        {{-- LISTA FILTRADA --}}
                        <div x-show="open && search.length > 0"
                             class="absolute bg-white border rounded-lg w-full mt-1 shadow-lg max-h-48 overflow-y-auto z-20">

                            <template x-for="subj in subjects.filter(s =>
                                s.name.toLowerCase().includes(search.toLowerCase())
                            )" :key="subj.subject_id">

                                <div class="p-2 hover:bg-gray-200 cursor-pointer"
                                     x-on:click="selectSubject(subj)"
                                     x-text="subj.name">
                                </div>

                            </template>

                        </div>

                    </div>

                    {{-- Select CARRERA --}}
                    <div>
                        <label class="font-semibold block mb-1">Carrera:</label>
                        <select :name="`subjects[${row.id}][career_id]`"
                                class="w-full p-2 border rounded-lg">
                            @foreach ($careers as $c)
                                <option value="{{ $c->career_id }}">{{ $c->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Botón eliminar --}}
                    <div class="flex items-end">
                        <button type="button"
                                x-on:click="removeRow(index)"
                                class="w-full bg-red-500 text-white p-2 rounded-lg hover:bg-red-600">
                            🗑 Quitar
                        </button>
                    </div>

                </div>

            </template>

            {{-- AGREGAR MATERIA --}}
            <button type="button"
                    x-on:click="addRow()"
                    class="w-full py-3 mb-6 bg-blue-600 text-white font-bold rounded-lg hover:bg-blue-700">
                ➕ Agregar otra materia
            </button>

        </div>

        {{-- BOTONES FINALES --}}
        <div class="flex gap-4">
            <button type="submit"
                    class="flex-1 py-3 text-white font-bold rounded-lg shadow hover:opacity-90"
                    style="background-color:#28A745;">
                Guardar Asignaciones
            </button>

            <a href="{{ route('basic_sciences.teacher_subjects.index') }}"
               class="flex-1 py-3 text-center bg-gray-300 rounded-lg font-bold hover:bg-gray-200">
                Cancelar
            </a>
        </div>

    </form>

</div>

</body>
</html>


