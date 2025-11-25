<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Editar Alumno</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <x-teachers-navbar/>

    <div class="flex-grow p-6">
        <div class="max-w-3xl mx-auto bg-white shadow-xl rounded-2xl p-8 border border-gray-200">

            {{-- TITLE --}}
            <h1 class="text-3xl font-extrabold text-gray-800 mb-6 flex items-center gap-2">
                ✏️ Editar Alumno
            </h1>

            {{-- ERRORS --}}
            @if ($errors->any())
                <div class="bg-red-100 border border-red-300 text-red-800 px-4 py-3 rounded-lg mb-6">
                    <strong class="font-semibold">Corrige los siguientes errores:</strong>
                    <ul class="list-disc list-inside mt-2">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            {{-- FORM --}}
            <form action="{{ route('teachers.students.update', $student->enrollment) }}"
                  method="POST" enctype="multipart/form-data"
                  class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @csrf
                @method('PUT')

                {{-- MATRÍCULA --}}
                <div class="md:col-span-2">
                    <label class="block font-medium text-gray-700 mb-1">Matrícula</label>
                    <input type="text" value="{{ $student->enrollment }}"
                           class="w-full border rounded-lg p-3 bg-gray-200 cursor-not-allowed"
                           readonly>
                </div>

                {{-- NOMBRE --}}
                <div class="md:col-span-2">
                    <label class="block font-medium text-gray-700 mb-1">Nombre</label>
                    <input type="text" name="name" value="{{ $student->name }}"
                           class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-500"
                           required>
                </div>

                {{-- APELLIDOS --}}
                <div>
                    <label class="block font-medium text-gray-700 mb-1">Apellido Paterno</label>
                    <input type="text" name="last_name_f" value="{{ $student->last_name_f }}"
                           class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-500"
                           required>
                </div>

                <div>
                    <label class="block font-medium text-gray-700 mb-1">Apellido Materno</label>
                    <input type="text" name="last_name_m" value="{{ $student->last_name_m }}"
                           class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-500">
                </div>

                {{-- SEMESTRE --}}
                <div>
                    <label class="block font-medium text-gray-700 mb-1">Semestre</label>
                    <input type="number" name="semester" min="1" max="12"
                           value="{{ $student->semester }}"
                           class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-500"
                           required>
                </div>

                {{-- GRUPO --}}
                <div>
                    <label class="block font-medium text-gray-700 mb-1">Grupo</label>
                    <input type="text" name="group" value="{{ $student->group }}"
                           class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-500"
                           required>
                </div>

                {{-- GÉNERO --}}
                <div>
                    <label class="block font-medium text-gray-700 mb-1">Género</label>
                    <select name="gender"
                            class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-500">
                        <option {{ $student->gender == 'Masculino' ? 'selected' : '' }}>Masculino</option>
                        <option {{ $student->gender == 'Femenino' ? 'selected' : '' }}>Femenino</option>
                        <option {{ $student->gender == 'Otro' ? 'selected' : '' }}>Otro</option>
                    </select>
                </div>

                {{-- EDAD --}}
                <div>
                    <label class="block font-medium text-gray-700 mb-1">Edad</label>
                    <input type="number" name="age" min="17" max="80"
                           value="{{ $student->age }}"
                           class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-500"
                           required>
                </div>

                {{-- CARRERA --}}
                <div class="md:col-span-2">
                    <label class="block font-medium text-gray-700 mb-1">Carrera</label>
                    <select name="career_id"
                            class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-blue-500"
                            required>
                        @foreach ($careers as $c)
                            <option value="{{ $c->career_id }}"
                                {{ $c->career_id == $student->career_id ? 'selected' : '' }}>
                                {{ $c->name }}
                            </option>
                        @endforeach
                    </select>
                </div>

                {{-- HORARIO --}}
                <div class="md:col-span-2 mt-2">
                    <label class="font-medium text-gray-700">Horario actual:</label><br>

                    @if ($student->schedule_file)
                        <a href="{{ asset('storage/'.$student->schedule_file) }}" target="_blank"
                           class="text-blue-600 underline">
                            📄 Ver archivo actual
                        </a>
                    @else
                        <span class="text-gray-500">No subido</span>
                    @endif
                </div>

                <div class="md:col-span-2">
                    <label class="block font-medium text-gray-700 mb-1">Subir nuevo horario (opcional)</label>
                    <input type="file" name="schedule_file"
                           class="border rounded-lg p-3 w-full bg-gray-50">
                </div>

                {{-- BOTONES --}}
                <div class="md:col-span-2 flex flex-col md:flex-row justify-between gap-3 mt-4">

                    <button type="submit"
                            class="w-full md:w-1/2 py-3 text-white font-bold rounded-lg shadow-lg hover:opacity-90"
                            style="background-color:#28A745;">
                        💾 Guardar Cambios
                    </button>

                    <a href="{{ route('teachers.students.index') }}"
                       class="w-full md:w-1/2 py-3 text-center text-white font-bold rounded-lg shadow-lg hover:opacity-90"
                       style="background-color:#6C757D;">
                        ← Volver al listado
                    </a>

                </div>

            </form>
        </div>
    </div>

    {{-- FOOTER --}}
    <x-basic-sciences-footer />

</body>

</html>
