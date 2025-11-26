<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Detalles de Asesorías</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <div class="fixed top-0 left-0 w-full z-50 shadow">
        <x-basic-sciences-navbar />
    </div>

    <main class="flex-1 mt-28 mb-24 px-4">

        <div class="max-w-7xl mx-auto bg-white shadow-xl rounded-xl p-6 sm:p-8">

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">

                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-800">
                    📄 Detalles de Asesorías
                </h1>

                <a href="{{ route('basic_sciences.advisories.index') }}"
                   class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold rounded-lg text-center">
                    ← Volver a Asesorías
                </a>

            </div>

            <form method="GET" class="flex flex-col sm:flex-row gap-3 mb-6">

                <input 
                    type="text"
                    name="materia"
                    value="{{ $materia }}"
                    placeholder="Buscar materia..."
                    class="border border-gray-300 rounded-lg px-4 py-2 w-full sm:w-64 focus:ring-2 focus:ring-blue-600"
                >

                <select name="estado"
                        class="border border-gray-300 rounded-lg px-4 py-2 w-full sm:w-40 focus:ring-2 focus:ring-blue-600">
                    <option value="">Todos</option>
                    <option value="Pendiente"  {{ $estado=='Pendiente' ? 'selected' : '' }}>Pendiente</option>
                    <option value="Aprobado"   {{ $estado=='Aprobado' ? 'selected' : '' }}>Aprobado</option>
                    <option value="Finalizado" {{ $estado=='Finalizado' ? 'selected' : '' }}>Finalizado</option>
                </select>

                <button class="px-4 py-2 bg-[#1ABC9C] text-white font-semibold rounded-lg hover:bg-[#0d8a74] shadow">
                    🔍 Buscar
                </button>

                @if($materia || $estado)
                <a href="{{ route('basic_sciences.advisory_details.index') }}"
                   class="px-4 py-2 text-red-600 font-semibold hover:text-red-800">
                    Limpiar
                </a>
                @endif
            </form>

            <a href="{{ route('basic_sciences.advisory_details.create') }}"
               class="inline-block bg-green-600 text-white px-4 py-2 rounded-lg shadow hover:bg-green-700 mb-4 text-sm sm:text-base">
                ➕ Crear Detalle de Asesoría
            </a>

            <div class="overflow-x-auto rounded-xl border border-gray-200 shadow">

                <table class="min-w-full text-xs sm:text-sm">

                    <thead class="text-white uppercase font-semibold" style="background-color:#0B3D7E;">
                        <tr>
                            <th class="px-4 py-3">Materia</th>
                            <th class="px-4 py-3">Alumnos</th>
                            <th class="px-4 py-3 text-center">Inicio</th>
                            <th class="px-4 py-3 text-center">Fin</th>
                            <th class="px-4 py-3 text-center">Día</th>
                            <th class="px-4 py-3 text-center whitespace-nowrap">Horario</th>
                            <th class="px-4 py-3">Estado</th>
                            <th class="px-4 py-3">Observaciones</th>
                            <th class="px-4 py-3 whitespace-nowrap">Completa</th>
                            <th class="px-4 py-3 text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody class="text-gray-800">

                        @foreach($details as $d)

                            @php
                                $adv = $d->advisories->first();
                                $start = $adv ? \Carbon\Carbon::parse($adv->start_date)->format('d/m/Y') : '—';
                                $end   = $adv ? \Carbon\Carbon::parse($adv->end_date)->format('d/m/Y') : '—';
                                $startT = $adv ? \Carbon\Carbon::parse($adv->start_time)->format('H:i') : '—';
                                $endT   = $adv ? \Carbon\Carbon::parse($adv->end_time)->format('H:i') : '—';
                            @endphp

                            <tr class="border-b hover:bg-gray-50 transition">

                                <td class="px-4 py-3 font-semibold">
                                    {{ $d->subject->name }}
                                </td>

                                <td class="px-4 py-3">
                                    <ul class="list-disc ml-6">
                                        @foreach($d->students as $s)
                                            <li>{{ $s->enrollment }} - {{ $s->name }} {{ $s->last_name_f }}</li>
                                        @endforeach
                                    </ul>
                                </td>

                                <td class="px-4 py-3 text-center">{{ $start }}</td>

                                <td class="px-4 py-3 text-center">{{ $end }}</td>

                                <td class="px-4 py-3 text-center capitalize">
                                    {{ $adv->day_of_week ?? '—' }}
                                </td>

                                <td class="px-4 py-3 text-center whitespace-nowrap">
                                    {{ $adv ? "$startT - $endT" : '—' }}
                                </td>

                                <td class="px-4 py-3">
                                    @if($d->status == 'Aprobado')
                                        <span class="px-2 py-1 bg-green-100 text-green-700 rounded">Aprobado</span>
                                    @elseif($d->status == 'Pendiente')
                                        <span class="px-2 py-1 bg-yellow-100 text-yellow-700 rounded">Pendiente</span>
                                    @else
                                        <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded">Finalizado</span>
                                    @endif
                                </td>

                                <td class="px-4 py-3">{{ $d->observations }}</td>

                                <td class="px-4 py-3">
                                    @if($adv)
                                        <a href="{{ route('basic_sciences.advisories.details', $adv->advisory_id) }}"
                                           class="text-indigo-600 hover:underline font-semibold">
                                            Ver asesoría
                                        </a>
                                    @endif
                                </td>

                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('basic_sciences.advisories.create', ['detail_id' => $d->advisory_detail_id]) }}"
                                       class="px-3 py-1 bg-green-600 text-white rounded-lg hover:bg-green-700 font-semibold text-xs sm:text-sm">
                                        ➕ Crear
                                    </a>
                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>
            </div>

        </div>

    </main>

   <div class="w-full mt-10">
    <x-basic-sciences-footer />
</div>

</body>
</html>


