<html>
    <head>
        <title>Detalles de Asesorías</title>
        <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    </head>
<body class="bg-gray-50 min-h-screen p-6">      
<div class="max-w-5xl mx-auto bg-white shadow p-6 rounded">

    <h1 class="text-2xl font-bold mb-4">Detalles de Asesorías</h1>

     <a href="{{ route('basic_sciences.index') }}"
               class="text-green-600 hover:text-green-800 font-medium">
                Regresar a inicio
            </a>

    {{-- BUSCADOR --}}
<form method="GET" class="flex gap-4 mb-4 items-end">

    

    {{-- Buscar por materia --}}
    <div>
        <label class="text-sm text-gray-700 font-medium">Materia</label>
        <input type="text" name="materia" value="{{ $materia }}"
               placeholder="Buscar materia..."
               class="border p-2 rounded w-48">
    </div>

    {{-- Buscar por estado --}}
    <div>
        <label class="text-sm text-gray-700 font-medium">Estado</label>
        <select name="estado" class="border p-2 rounded w-40">
            <option value="">Todos</option>
            <option value="Pending"   {{ $estado=='Pending' ? 'selected' : '' }}>Pendiente</option>
            <option value="Approved"  {{ $estado=='Approved' ? 'selected' : '' }}>Aprobado</option>
            <option value="Rejected"  {{ $estado=='Rejected' ? 'selected' : '' }}>Rechazado</option>
        </select>
    </div>

    <button class="bg-blue-600 text-white px-4 py-2 rounded shadow">
        Buscar
    </button>

    {{-- Botón limpiar --}}
    @if($materia || $estado)
        <a href="{{ route('basic_sciences.advisory_details.index') }}"
           class="text-red-600 px-3 py-2">
           Limpiar
        </a>
    @endif
</form>


    <a href="{{ route('basic_sciences.advisory_details.create') }}"
       class="bg-green-600 text-white px-3 py-2 rounded mb-4 inline-block">
       Crear Detalle
    </a>

   <table class="w-full border mt-3 text-sm">
    <thead class="bg-gray-100">
        <tr>
            <th class="border px-2 py-1">ID</th>
            <th class="border px-2 py-1">Materia</th>
            <th class="border px-2 py-1">Alumnos</th>
            <th class="border px-2 py-1">Estado</th>
            <th class="border px-2 py-1">Observaciones</th>
            <th class="border px-2 py-1">Acciones</th>
        </tr>
    </thead>

    <tbody>
    @foreach($details as $d)
        <tr>
            <td class="border px-2 py-1">{{ $d->advisory_detail_id }}</td>

            <td class="border px-2 py-1">
                {{ $d->subject->name ?? 'Sin asesoría creada' }}
            </td>

            <td class="border px-2 py-1">
                <ul class="list-disc ml-4">
                    @foreach($d->students as $s)
                        <li>{{ $s->enrollment }} - {{ $s->name }} {{ $s->last_name_f }}</li>
                    @endforeach
                </ul>
            </td>

            <td class="border px-2 py-1">{{ $d->status }}</td>

            <td class="border px-2 py-1">{{ $d->observations }}</td>

            <td class="border px-2 py-1 space-x-2">
                <a href="{{ route('basic_sciences.advisory_details.show', $d) }}"
                   class="text-blue-600">Ver</a>

                <a href="{{ route('basic_sciences.advisories.create', ['detail_id' => $d->advisory_detail_id]) }}"
                   class="text-green-600 font-bold">
                   Crear Asesoría
                </a>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>


</div>
</body>
</html>
