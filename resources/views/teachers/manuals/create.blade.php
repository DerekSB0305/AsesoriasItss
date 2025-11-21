<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <title>Subir Manual</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

     <div class="flex-grow p-6">

    <div class="max-w-xl mx-auto bg-white p-8 rounded-xl shadow-xl">

        <a href="{{ route('teachers.manuals.index') }}"
           class="text-indigo-600 hover:text-indigo-800">
            ← Regresar
        </a>

        <h1 class="text-3xl font-bold text-gray-800 mt-4 mb-6">
            📘 Subir manual
        </h1>

        <p class="text-gray-700 mb-4">
            Materia:
            <span class="font-semibold text-indigo-700">
                {{ $teacherSubject->subject->name }}
            </span>
        </p>

            <form action="{{ route('teachers.manuals.store', $teacherSubject->teacher_subject_id) }}"
        method="POST"
        enctype="multipart/form-data"
        class="space-y-5">


            @csrf

            {{-- Título --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-1">
                    Título del manual:
                </label>
                <input type="text" name="title"
                       class="w-full border border-gray-300 rounded-lg p-2 focus:ring-indigo-500 focus:border-indigo-500"
                       required>
            </div>

            {{-- Archivo --}}
            <div>
                <label class="block text-gray-700 font-semibold mb-1">
                    Seleccionar archivo:
                </label>
                <input type="file" name="file"
                       class="w-full border border-gray-300 p-2 rounded-lg"
                       required>
                <p class="text-sm text-gray-500 mt-1">Formatos permitidos: pdf, doc, docx, ppt, pptx</p>
            </div>

            {{-- Botón --}}
            <button type="submit"
                    class="w-full bg-indigo-600 text-white py-3 rounded-lg font-semibold hover:bg-indigo-700 transition">
                Subir manual
            </button>

        </form>

    </div>

    </div>
    <x-basic-sciences-footer />
</body>

</html>
