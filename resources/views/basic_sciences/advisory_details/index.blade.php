<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Detalles de Asesorías</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen p-6">

<div class="max-w-6xl mx-auto bg-white shadow-lg rounded-xl p-8">

    {{-- Título --}}
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-3xl font-extrabold text-gray-800">📄 Detalles de Asesorías</h1>

        <a href="{{ route('basic_sciences.index') }}"
           class="text-green-600 hover:text-green-800 font-semibold">
            ← Regresar al inicio
        </a>
    </div>

    {{-- BUSCADOR --}}
    <form method="GET" class="flex flex-wrap gap-4 mb-6 items-end">

        {{-- BUSCAR MATERIA --}}
        <div>
            <label class="text-sm font-semibold text-gray-700">Materia</label>
            <input type="text" name="materia" value="{{ $materia }}"
                placeholder="Buscar materia..."
                class="border border-gray-300 px-3 py-2 rounded-lg w-48 
                       focus:ring-2 focus:ring-blue-500 focus:outline-none">
        </div>

        {{-- ESTADO --}}
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

        {{-- BOTÓN BUSCAR --}}
        <button class="bg-blue-600 text-white px-5 py-2 rounded-lg shadow hover:bg-blue-700">
            Buscar
        </button>

        {{-- LIMPIAR --}}
        @if($materia || $estado)
            <a href="{{ route('basic_sciences.advisory_details.index') }}"
               class="text-red-600 font-semibold hover:text-red-800 px-3 py-2">
               Limpiar
            </a>
        @endif
    </form>

    {{-- BOTÓN CREAR DETALLE --}}
    <a href="{{ route('basic_sciences.advisory_details.create') }}"
       class="bg-green-600 text-white px-4 py-2 rounded-lg shadow hover:bg-green-700 inline-block mb-5">
        ➕ Crear Detalle de Asesoría
    </a>

    {{-- TABLA --}}
    <div class="overflow-x-auto border border-gray-300 rounded-xl shadow">
        <table class="min-w-full border-collapse text-sm">

            {{-- ENCABEZADOS --}}
            <thead style="background-color:#0B3D7E;" class="text-white font-bold">
                <tr>
                    <th class="px-4 py-3">ID</th>
                    <th class="px-4 py-3">Materia</th>
                    <th class="px-4 py-3">Alumnos</th>
                    <th class="px-4 py-3">Estado</th>
                    <th class="px-4 py-3">Observaciones</th>
                    <th class="px-4 py-3 text-center">Acciones</th>
                </tr>
            </thead>

            {{-- CUERPO --}}
            <tbody class="text-gray-700">

            @foreach($details as $d)
                <tr class="border-b hover:bg-gray-50 transition">

                    {{-- ID --}}
                    <td class="px-4 py-3 font-semibold">{{ $d->advisory_detail_id }}</td>

                    {{-- MATERIA --}}
                    <td class="px-4 py-3">
                        {{ $d->subject->name ?? 'Sin asesoría creada' }}
                    </td>

                    {{-- ALUMNOS --}}
                    <td class="px-4 py-3">
                        <ul class="list-disc ml-5">
                            @foreach($d->students as $s)
                                <li>{{ $s->enrollment }} - {{ $s->name }} {{ $s->last_name_f }}</li>
                            @endforeach
                        </ul>
                    </td>

                    {{-- ESTADO --}}
                    <td class="px-4 py-3">
                        <span class="font-semibold">{{ $d->status }}</span>
                    </td>

                    {{-- OBSERVACIONES --}}
                    <td class="px-4 py-3">
                        {{ $d->observations }}
                    </td>

                    {{-- ACCIONES --}}
                    <td class="px-4 py-3 text-center space-y-1">

                        <br>

                        {{-- Crear Asesoría --}}
                        <a href="{{ route('basic_sciences.advisories.create', ['detail_id' => $d->advisory_detail_id]) }}"
                           class="text-white font-semibold px-3 py-1 rounded-lg"
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

</body>
</html>
