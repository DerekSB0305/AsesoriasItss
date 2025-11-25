<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Documentos</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

<x-basic-sciences-navbar />

<div class="max-w-6xl mx-auto bg-white shadow-lg rounded-xl p-8 my-10 flex-1 w-full">

    <h1 class="text-3xl font-bold text-[#0B3D7E] mb-6 text-center">
        📘 Documentos
    </h1>

    {{-- Botón agregar + buscador --}}
    <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">

        <a href="{{ route('basic_sciences.documents.create') }}"
           class="px-4 py-2 bg-[#28A745] text-white rounded-lg shadow hover:bg-[#28A745] w-full md:w-auto text-center">
            ➕ Subir documento
        </a>

        <form method="GET" class="flex w-full md:w-auto gap-3">
            <input type="text"
                   name="buscar"
                   value="{{ request('buscar') }}"
                   placeholder="Buscar documento..."
                   class="px-4 py-2 border rounded-lg w-full md:w-64 focus:ring-2 focus:ring-[#0B3D7E]">

            <button class="px-4 py-2 bg-[#159a82] text-white rounded-lg shadow hover:bg-[#159a82]">
                🔍 Buscar
            </button>
        </form>

    </div>

    {{-- Tabla --}}
    <div class="overflow-x-auto rounded-xl border shadow">
        <table class="w-full border-collapse text-sm">

            <thead class="text-white uppercase font-semibold" style="background-color:#0B3D7E;">
                <tr>
                    <th class="px-4 py-3">Nombre</th>
                    <th class="px-4 py-3">Archivo</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
            </thead>

            <tbody class="text-gray-800">

                @forelse ($documents as $d)
                <tr class="border-b hover:bg-gray-50 transition">

                    <td class="px-4 py-3 font-semibold">
                        {{ $d->name }}
                    </td>

                    <td class="px-4 py-3">
                        <a class="text-blue-600 hover:text-blue-800 underline"
                           href="{{ asset('storage/'.$d->file_path) }}" target="_blank">
                            📄 Ver archivo
                        </a>
                    </td>

                    <td class="px-4 py-3 text-center">
                       <form action="{{ route('basic_sciences.documents.destroy', ['document' => $d]) }}"
                        method="POST"onsubmit="return confirm('¿Eliminar documento?');">
                        @csrf
                        @method('DELETE')
                            <button class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600">
                                 🗑 Eliminar
                            </button>
                        </form>
                    </td>

                </tr>
                @empty

                <tr>
                    <td colspan="3" class="px-4 py-4 text-center text-gray-500">
                        No hay documentos registrados.
                    </td>
                </tr>

                @endforelse

            </tbody>

        </table>
    </div>

</div>

<x-basic-sciences-footer />

</body>
</html>
