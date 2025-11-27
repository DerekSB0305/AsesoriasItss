<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asesorías</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <div class="fixed top-0 left-0 w-full z-50 shadow">
        <x-basic-sciences-navbar />
    </div>

    <main class="flex-1 mt-28 mb-24 px-4">

        <div class="max-w-7xl mx-auto bg-white shadow-xl rounded-xl p-6 sm:p-8">

            {{-- Título --}}
            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                <h1 class="text-2xl sm:text-3xl font-extrabold text-gray-800">
                    📚 Asesorías Registradas
                </h1>

                <div class="flex flex-col sm:flex-row gap-3 text-sm">

                    <a href="{{ route('basic_sciences.advisory_details.create') }}"
                       class="px-4 py-2 rounded-lg text-white font-semibold text-center hover:opacity-90"
                       style="background-color:#28A745;">
                        ➕ Crear Detalle Asesoría
                    </a>

                    <a href="{{ route('basic_sciences.advisory_details.index') }}"
                       class="px-4 py-2 bg-white border border-green-600 text-green-700 rounded-lg font-semibold hover:bg-green-600 hover:text-white shadow-md transition">
                        📄 Ver Detalles
                    </a>

                    <a href="{{ route('basic_sciences.index') }}"
                       class="px-4 py-2 bg-gray-300 hover:bg-gray-400 text-gray-800 rounded-lg font-semibold text-center">
                        ← Volver
                    </a>

                </div>
            </div>

            {{-- Buscar --}}
            <form method="GET" class="flex flex-col sm:flex-row gap-3 mb-6">
                <input 
                    type="text"
                    name="q"
                    placeholder="Buscar por maestro o materia..."
                    value="{{ request('q') }}"
                    class="border border-gray-300 rounded-lg px-4 py-2 w-full sm:w-72 focus:ring-2 focus:ring-blue-600"
                >
                
                <button class="px-4 py-2 bg-[#1ABC9C] text-white font-semibold rounded-lg hover:bg-[#0d8a74] shadow">
                    🔍 Buscar
                </button>
            </form>

            {{-- Tabla --}}
            @php
                $hasFinalized = $advisories->contains(fn($a) => $a->advisoryDetail->status === 'Finalizado');
            @endphp

            <div class="overflow-x-auto rounded-xl border border-gray-200 shadow">

                <table class="min-w-full text-xs sm:text-sm">

                    <thead class="text-white uppercase font-semibold" style="background-color:#0B3D7E;">
                        <tr>
                            <th class="px-4 py-3 whitespace-nowrap">Maestro</th>
                            <th class="px-4 py-3 whitespace-nowrap">Carrera</th>
                            <th class="px-4 py-3 whitespace-nowrap">Materia</th>
                            <th class="px-4 py-3 whitespace-nowrap">Inicio</th>
                            <th class="px-4 py-3 whitespace-nowrap">Fin</th>
                            <th class="px-4 py-3 whitespace-nowrap">Día & Hora</th>
                            <th class="px-4 py-3 text-center whitespace-nowrap">Total</th>
                            <th class="px-4 py-3 text-center">H</th>
                            <th class="px-4 py-3 text-center">M</th>
                            <th class="px-4 py-3 whitespace-nowrap">Aula</th>
                            <th class="px-4 py-3 whitespace-nowrap">Edificio</th>
                            <th class="px-4 py-3 whitespace-nowrap">Archivo</th>
                            <th class="px-4 py-3 whitespace-nowrap">Detalles</th>

                            {{-- Mostrar solo si existen asesorías finalizadas --}}
                            @if($hasFinalized)
                                <th class="px-4 py-3 whitespace-nowrap text-center">Ver Evaluación</th>
                            @endif

                            <th class="px-4 py-3 text-center whitespace-nowrap">Acciones</th>
                        </tr>
                    </thead>

                    <tbody class="text-gray-800">

                        @foreach($advisories as $adv)
                            @php
                                $students = $adv->advisoryDetail->students ?? collect();
                                $startDate = \Carbon\Carbon::parse($adv->start_date)->format('d/m/Y');
                                $endDate   = \Carbon\Carbon::parse($adv->end_date)->format('d/m/Y');
                                $startTime = \Carbon\Carbon::parse($adv->start_time)->format('H:i');
                                $endTime   = \Carbon\Carbon::parse($adv->end_time)->format('H:i');
                            @endphp

                            <tr class="border-b hover:bg-gray-100 transition">

                                <td class="px-4 py-3">{{ $adv->teacherSubject->teacher->name }}</td>

                                <td class="px-4 py-3">{{ $adv->teacherSubject->subject->career->name }}</td>

                                <td class="px-4 py-3">{{ $adv->teacherSubject->subject->name }}</td>

                                <td class="px-4 py-3 font-semibold">{{ $startDate }}</td>

                                <td class="px-4 py-3 font-semibold">{{ $endDate }}</td>

                                <td class="px-4 py-3 font-semibold whitespace-nowrap">
                                    <strong>{{ $adv->day_of_week }}</strong>
                                    {{ $startTime }} - {{ $endTime }}
                                </td>

                                <td class="px-4 py-3 text-center font-bold">{{ $students->count() }}</td>

                                <td class="px-4 py-3 text-center text-blue-600 font-bold">
                                    {{ $students->where('gender', 'Masculino')->count() }}
                                </td>

                                <td class="px-4 py-3 text-center text-pink-600 font-bold">
                                    {{ $students->where('gender', 'Femenino')->count() }}
                                </td>

                                <td class="px-4 py-3">{{ $adv->classroom }}</td>

                                <td class="px-4 py-3">{{ $adv->building }}</td>

                                <td class="px-4 py-3">
                                    @if($adv->assignment_file)
                                        <a href="{{ asset('storage/' . $adv->assignment_file) }}"
                                           target="_blank"
                                           class="text-blue-600 hover:underline">
                                           Ver archivo
                                        </a>
                                    @else
                                        <span class="text-gray-500">Sin archivo</span>
                                    @endif
                                </td>

                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('basic_sciences.advisories.details', $adv->advisory_id) }}"
                                       class="text-indigo-600 font-semibold hover:underline">
                                        Ver detalles
                                    </a>
                                </td>

                                {{-- Solo si tenemos asesorías finalizadas --}}
                                @if($hasFinalized)
                                    <td class="px-4 py-3 text-center">

                                        {{-- Solo si esta asesoría YA finalizó --}}
                                        @if($adv->advisoryDetail->status === 'Finalizado')

                                            <a href="{{ route('basic_sciences.evaluation', $adv->advisory_id) }}"
                                               class="text-green-600 font-semibold hover:underline">
                                                Ver evaluación
                                            </a>

                                        @else
                                            <span class="text-gray-400 text-xs">Asesoría en curso</span>
                                        @endif

                                    </td>
                                @endif

                                <td class="px-4 py-3 flex flex-col sm:flex-row gap-2 justify-center">

                                    <a href="{{ route('basic_sciences.advisories.edit', $adv->advisory_id) }}"
                                       class="px-3 py-1 text-white rounded font-semibold hover:opacity-90"
                                       style="background-color:#F39C12;">
                                        Editar
                                    </a>

                                    <button onclick="openDeleteModal('{{ $adv->teacherSubject->subject->name }}', '{{ $adv->advisory_id }}')"
                                        class="px-3 py-1 text-white rounded font-semibold hover:opacity-90"
                                        style="background-color:#E74C3C;">
                                        Eliminar
                                    </button>

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


    {{-- Modal eliminar --}}
    <div id="deleteModal"
         class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">

        <div class="bg-white w-full max-w-md p-6 rounded-xl shadow-2xl">

            <h2 class="text-xl font-bold text-red-600 mb-4">⚠ Confirmar eliminación</h2>

            <p class="text-gray-700">
                ¿Eliminar la asesoría de <strong id="advisoryName"></strong>?
                <br>Esta acción es irreversible.
            </p>

            <form id="deleteForm" method="POST">
                @csrf
                @method('DELETE')

                <div class="flex justify-end gap-3 mt-6">

                    <button type="button"
                        onclick="closeDeleteModal()"
                        class="px-4 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600">
                        Cancelar
                    </button>

                    <button type="submit"
                        class="px-4 py-2 bg-red-600 text-white rounded-lg hover:bg-red-700">
                        Eliminar
                    </button>

                </div>

            </form>

        </div>

    </div>

    <script>
        function openDeleteModal(name, id) {
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('advisoryName').innerText = name;
            document.getElementById('deleteForm').action =
                "/basic_sciences/advisories/" + encodeURIComponent(id);
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
    </script>

</body>
</html>


