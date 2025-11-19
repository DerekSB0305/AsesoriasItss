<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles de Asesorías</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <x-basic-sciences-navbar />

    <div class="flex-1">

        <div class="max-w-6xl mx-auto bg-white shadow-lg rounded-xl p-8 mt-10">

            <div class="flex justify-between items-center mb-6">
                <h1 class="text-3xl font-extrabold text-gray-800 flex items-center gap-2">
                    📄 Detalles de Asesorías
                </h1>

                <a href="{{ route('basic_sciences.advisories.index') }}"
                   class="text-green-600 hover:text-green-800 font-semibold">
                    ← Regresar a Asesorías
                </a>
            </div>

            <form method="GET" class="flex flex-wrap gap-4 mb-6 items-end">

                <div>
                    <label class="text-sm font-semibold text-gray-700">Materia</label>
                    <input type="text" name="materia" value="{{ $materia }}"
                        placeholder="Ej. Cálculo"
                        class="border border-gray-300 px-3 py-2 rounded-lg w-48
                               focus:ring-2 focus:ring-blue-500 focus:outline-none">
                </div>

                <div>
                    <label class="text-sm font-semibold text-gray-700">Estado</label>
                    <select name="estado"
                            class="border border-gray-300 px-3 py-2 rounded-lg w-40
                                   focus:ring-2 focus:ring-blue-500">
                        <option value="">Todos</option>
                        <option value="Pendiente"  {{ $estado=='Pendiente' ? 'selected' : '' }}>Pendiente</option>
                        <option value="Aprobado"   {{ $estado=='Aprobado' ? 'selected' : '' }}>Aprobado</option>
                        <option value="Finalizado" {{ $estado=='Finalizado' ? 'selected' : '' }}>Finalizado</option>
                    </select>
                </div>

                <button class="mt-4 px-4 py-2 bg-[#1ABC9C] text-white font-semibold rounded-lg hover:bg-blue-900 shadow">
                🔍 Buscar
                </button>

                @if($materia || $estado)
                    <a href="{{ route('basic_sciences.advisory_details.index') }}"
                       class="text-red-600 font-semibold hover:text-red-800 px-3 py-2">
                       Limpiar
                    </a>
                @endif
            </form>

            <a href="{{ route('basic_sciences.advisory_details.create') }}"
               class="bg-green-600 text-white px-4 py-2 rounded-lg shadow hover:bg-green-700 inline-flex items-center gap-2 mb-4">
                ➕ Crear Detalle de Asesoría
            </a>

            <div class="overflow-x-auto border border-gray-300 rounded-xl shadow">
                <table class="min-w-full border-collapse text-sm">

                    <thead style="background-color:#0B3D7E;" class="text-white font-bold">
                        <tr>
                            <th class="px-4 py-3">Materia</th>
                            <th class="px-4 py-3">Alumnos</th>
                            <th class="px-4 py-3">Estado</th>
                            <th class="px-4 py-3">Observaciones</th>
                            <th class="px-4 py-3 text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody class="text-gray-700">

                    @foreach($details as $d)
                        <tr class="border-b hover:bg-gray-50 transition">

                            <td class="px-4 py-3">
                                {{ $d->subject->name ?? 'Sin asesoría creada' }}
                            </td>

                            <td class="px-4 py-3">
                                <ul class="list-disc ml-5">
                                    @foreach($d->students as $s)
                                        <li>{{ $s->enrollment }} - {{ $s->name }} {{ $s->last_name_f }}</li>
                                    @endforeach
                                </ul>
                            </td>

                            <td class="px-4 py-3 font-semibold">
                                @if($d->status === 'Aprobado')
                                    <span class="px-2 py-1 bg-green-100 text-green-700 rounded">
                                        Aprobado
                                    </span>
                                @elseif($d->status === 'Pendiente')
                                    <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded">
                                        Pendiente
                                    </span>
                                @else
                                    <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded">
                                        Finalizado
                                    </span>
                                @endif
                            </td>

                            <td class="px-4 py-3">
                                {{ $d->observations }}
                            </td>

                            <td class="px-4 py-3 text-center">

                                <a href="{{ route('basic_sciences.advisories.create', ['detail_id' => $d->advisory_detail_id]) }}"
                                   class="text-white font-semibold px-3 py-1 rounded-lg inline-flex items-center gap-1"
                                   style="background-color:#28A745;">
                                    ➕ Crear Asesoría
                                </a>

                            </td>

                        </tr>
                    @endforeach

                    </tbody>

                </table>
            </div>

        </div>

    </div>

    {{-- FOOTER --}}
    <x-basic-sciences-footer />

</body>
</html>


