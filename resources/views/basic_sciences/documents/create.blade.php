<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Subir Documento</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <div class="fixed top-0 left-0 w-full z-50 shadow">
        <x-basic-sciences-navbar />
    </div>

    <main class="flex-1 mt-32 px-4 mb-24">

        <div class="max-w-lg mx-auto bg-white shadow-lg rounded-xl p-6 sm:p-8 w-full">

            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0B3D7E] mb-8 text-center">
                📄 Subir documento
            </h1>

            @if ($errors->any())
                <div class="bg-red-100 text-red-700 border border-red-300 p-4 rounded mb-6">
                    <strong class="font-semibold">⚠ Hay errores en el formulario:</strong>
                    <ul class="list-disc ml-5 mt-2 text-sm">
                        @foreach ($errors->all() as $e)
                            <li>{{ $e }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('basic_sciences.documents.store') }}"
                  method="POST"
                  enctype="multipart/form-data"
                  class="space-y-6">

                @csrf

                <div>
                    <label class="font-semibold text-gray-700">Nombre del documento</label>
                    <input type="text"
                           name="name"
                           class="mt-1 w-full px-3 py-2 border rounded-lg text-sm focus:ring-[#0B3D7E] focus:border-[#0B3D7E]"
                           required>
                </div>

                <div>
                    <label class="font-semibold text-gray-700">Archivo</label>
                    <input type="file"
                           name="file"
                           class="mt-1 w-full px-3 py-2 border rounded-lg text-sm focus:ring-[#0B3D7E] focus:border-[#0B3D7E]"
                           required>
                </div>

                <div class="flex flex-col sm:flex-row gap-4">

                    <a href="{{ route('basic_sciences.documents.index') }}"
                       class="w-full sm:w-1/2 text-center py-2 bg-gray-400 text-white rounded-lg hover:bg-gray-500 font-semibold transition">
                        Cancelar
                    </a>

                    <button type="submit"
                            class="w-full sm:w-1/2 py-2 bg-[#28A745] text-white rounded-lg hover:bg-[#28A745] shadow font-semibold transition">
                        Subir Documento
                    </button>

                </div>

            </form>

        </div>

    </main>


    <x-basic-sciences-footer />

</body>
</html>

