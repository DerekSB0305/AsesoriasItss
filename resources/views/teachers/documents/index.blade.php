<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Documentos</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

<x-teachers-navbar/>

<div class="flex-grow p-6">

    <div class="max-w-4xl mx-auto bg-white shadow-xl rounded-2xl p-8">

        <h1 class="text-3xl font-extrabold text-gray-800 mb-6 text-center">
            📂 Documentos Disponibles
        </h1>

        <div class="overflow-x-auto rounded-xl border shadow">
            <table class="w-full border-collapse text-sm">

                <thead class="text-white uppercase font-semibold" style="background-color:#0B3D7E;">
                    <tr>
                        <th class="px-4 py-3 text-left">Nombre</th>
                        <th class="px-4 py-3 text-center">Descargar</th>
                    </tr>
                </thead>

                <tbody class="text-gray-800">

                    @forelse ($documents as $doc)
                        <tr class="border-b hover:bg-gray-50 transition">

                            <td class="px-4 py-3 font-semibold">
                                {{ $doc->name }}
                            </td>

                            <td class="px-4 py-3 text-center">
                                <a href="{{ asset('storage/'.$doc->file_path) }}"
                                   class="px-3 py-2 bg-green-600 text-white rounded-lg shadow hover:bg-green-700"
                                   target="_blank">
                                    ⬇ Descargar
                                </a>
                            </td>

                        </tr>

                    @empty
                        <tr>
                            <td colspan="2" class="px-4 py-4 text-center text-gray-500">
                                No hay documentos disponibles.
                            </td>
                        </tr>
                    @endforelse

                </tbody>

            </table>
        </div>

    </div>

</div>

<x-basic-sciences-footer/>

</body>
</html>
