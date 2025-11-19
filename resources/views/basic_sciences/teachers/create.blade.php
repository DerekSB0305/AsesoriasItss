<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Crear Maestro</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <x-basic-sciences-navbar />
    
    <div class="w-full max-w-4xl mx-auto bg-white shadow-xl rounded-xl p-10 mt-8 ">

        <h1 class="text-4xl font-extrabold text-[#0B3D7E] mb-8 flex items-center gap-3">
            👨‍🏫 Crear Maestro
        </h1>

        {{-- ERRORES --}}
        @if ($errors->any())
            <div class="mb-6 bg-red-100 border border-red-300 text-red-700 p-5 rounded-lg shadow">
                <p class="font-semibold text-lg mb-2">⚠️ Corrige los siguientes errores:</p>
                <ul class="list-disc ml-6 space-y-1">
                    @foreach ($errors->all() as $e)
                        <li>{{ $e }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('basic_sciences.teachers.store') }}"
              method="POST"
              enctype="multipart/form-data"
              class="grid grid-cols-1 md:grid-cols-2 gap-6">

            @csrf

            <div class="col-span-2">
                <label class="font-semibold text-[#0B3D7E] block mb-1">Usuario:</label>
                <input type="text" name="teacher_user"
                       class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-[#0B3D7E]"
                       required>
            </div>

            <div>
                <label class="font-semibold text-[#0B3D7E] mb-1 block">Nombre(s):</label>
                <input type="text" name="name"
                       class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-[#0B3D7E]"
                       required>
            </div>

            <div>
                <label class="font-semibold text-[#0B3D7E] mb-1 block">Apellido paterno:</label>
                <input type="text" name="last_name_f"
                       class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-[#0B3D7E]"
                       required>
            </div>

            <div>
                <label class="font-semibold text-[#0B3D7E] mb-1 block">Apellido materno:</label>
                <input type="text" name="last_name_m"
                       class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-[#0B3D7E]"
                       required>
            </div>

            <div>
                <label class="font-semibold text-[#0B3D7E] mb-1 block">Grado de estudios:</label>
                <input type="text" name="degree"
                       class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-[#0B3D7E]"
                       required>
            </div>

            <div>
                <label class="font-semibold text-[#0B3D7E] mb-1 block">¿Es tutor?</label>
                <select name="tutor"
                        class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-[#0B3D7E]">
                    <option value="0">No</option>
                    <option value="1">Sí</option>
                </select>
            </div>

            <div>
                <label class="font-semibold text-[#0B3D7E] mb-1 block">¿Tiene horas de Ciencias Básicas?</label>
                <select name="science_department"
                        class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-[#0B3D7E]">
                    <option value="0">No</option>
                    <option value="1">Sí</option>
                </select>
            </div>

            <div class="col-span-2">
                <label class="font-semibold text-[#0B3D7E] mb-1 block">Carrera:</label>
                <select name="career_id"
                        class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-[#0B3D7E]" required>
                    <option value="">Seleccione una carrera</option>
                    @foreach($careers as $c)
                        <option value="{{ $c->career_id }}">{{ $c->name }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-span-2">
                <label class="font-semibold text-[#0B3D7E] mb-1 block">Horario (PDF, JPG, PNG):</label>
                <input type="file" name="schedule"
                       class="w-full p-3 border rounded-lg focus:ring-2 focus:ring-[#0B3D7E]">
            </div>

            <div class="col-span-2 flex justify-between gap-4 mt-6">

                <a href="{{ route('basic_sciences.teachers.index') }}"
                   class="w-1/2 py-3 text-center text-white font-bold rounded-lg shadow hover:opacity-90"
                   style="background-color:#6C757D;">
                    Cancelar
                </a>

                <button type="submit"
                        class="w-1/2 py-3 text-white font-bold rounded-lg shadow hover:opacity-90"
                        style="background-color:#28A745;">
                    Guardar Maestro
                </button>

            </div>

        </form>

    </div>

    <x-basic-sciences-footer />

</body>
</html>



