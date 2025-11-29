<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentos</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <div class="fixed top-0 left-0 w-full z-50 shadow">
        <x-basic-sciences-navbar />
    </div>

    <main class="flex-1 mt-32 px-4 mb-24">

        <div class="max-w-6xl mx-auto bg-white shadow-lg rounded-xl p-6 sm:p-8">

            <h1 class="text-2xl sm:text-3xl font-extrabold text-[#0B3D7E] mb-6 text-center">
                📘 Documentos
            </h1>

            <div class="mb-6">
                <a href="{{ route('basic_sciences.index') }}" 
                   class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold transition">
                    ← Volver al inicio
                </a>
            </div>

            <div class="flex flex-col md:flex-row justify-between items-center gap-4 mb-6">

                <a href="{{ route('basic_sciences.documents.create') }}"
                   class="px-4 py-2 bg-[#28A745] text-white rounded-lg font-semibold shadow hover:bg-green-700 w-full md:w-auto text-center">
                    ➕ Subir documento
                </a>

                <form method="GET" class="flex w-full md:w-auto gap-3">
                    <input type="text"
                           name="buscar"
                           value="{{ request('buscar') }}"
                           placeholder="Buscar documento..."
                           class="px-4 py-2 border rounded-lg w-full md:w-64 focus:ring-2 focus:ring-[#0B3D7E]">

                    <button class="px-4 py-2 bg-[#159a82] text-white rounded-lg shadow hover:bg-[#117a69]">
                        🔍 Buscar
                    </button>
                </form>

            </div>

            <div class="overflow-x-auto rounded-xl border shadow">

                <table class="min-w-full text-xs sm:text-sm">

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
                                <a href="{{ asset('storage/'.$d->file_path) }}"
                                   target="_blank"
                                   class="text-blue-600 hover:text-blue-800 underline">
                                    📄 Ver archivo
                                </a>
                            </td>

                            <td class="px-4 py-3 text-center">
                                <form action="{{ route('basic_sciences.documents.destroy', ['document' => $d]) }}"
                                      method="POST"
                                      onsubmit="return confirm('¿Eliminar documento?');">
                                    @csrf
                                    @method('DELETE')

                                    <button class="px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 text-xs sm:text-sm">
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

            <div class="mt-6 flex justify-center">
                {{ $documents->links('vendor.pagination.tailwind') }}
            </div>

        </div>

    </main>

    <x-basic-sciences-footer />

</body>
</html>

