<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asesorías</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

    <!-- NAVBAR FIJO -->
    <div class="fixed top-0 left-0 w-full z-50 shadow">
        <x-basic-sciences-navbar />
    </div>

    <main class="flex-1 mt-28 mb-24 px-4">

        <div class="max-w-7xl mx-auto bg-white shadow-xl rounded-xl p-8">

            <!-- ENCABEZADO -->
            <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8">

                <h1 class="text-3xl font-extrabold text-gray-800">
                    📚 Asesorías Registradas
                </h1>

                <div class="flex flex-col sm:flex-row gap-3 mt-4 sm:mt-0">

                    <!-- Botón Crear Detalle -->
                    <a href="{{ route('basic_sciences.advisory_details.create') }}"
                       class="px-4 py-2 rounded-lg text-white font-semibold text-center hover:opacity-90"
                       style="background-color:#28A745;">
                        ➕ Crear Detalle Asesoría
                    </a>

                    <!-- Botón Ver Detalles -->
                    <a href="{{ route('basic_sciences.advisory_details.index') }}"
                       class="px-4 py-2 bg-white border border-green-600 text-green-700 rounded-lg font-semibold hover:bg-green-600 hover:text-white shadow-sm transition">
                        📄 Ver Todos Los Detalles
                    </a>

                    <!-- Botón Volver -->
                    <a href="{{ route('basic_sciences.index') }}"
                       class="px-4 py-2 rounded bg-gray-300 hover:bg-gray-400 text-gray-800 font-semibold text-center">
                        ← Volver
                    </a>

                </div>

            </div>

            <!-- BUSCADOR -->
            <form method="GET" class="mb-6 flex gap-3">
                <input 
                    type="text"
                    name="q"
                    placeholder="Buscar por maestro o materia..."
                    value="{{ request('q') }}"
                    class="border border-gray-300 rounded-lg px-4 py-2 w-72 focus:ring-2 focus:ring-blue-600 focus:outline-none"
                >
                
                <button class="mt-4 px-4 py-2 bg-[#1ABC9C] text-white font-semibold rounded-lg hover:bg-blue-900 shadow">
                    🔍 Buscar
                </button>
            </form>

            <!-- TABLA -->
            <div class="overflow-x-auto rounded-xl border border-gray-300 shadow">
                <table class="min-w-full border-collapse text-sm">

                    <thead class="text-white uppercase text-xs font-semibold" style="background-color:#0B3D7E;">
                        <tr class="border-b">
                            <th class="px-4 py-3">Maestro</th>
                            <th class="px-4 py-3">Carrera</th>
                            <th class="px-4 py-3">Materia</th>
                            <th class="px4 py-3" >Fecha inicio</th>
                            <th class="px-4 py-3">Fecha fin</th>
                            <th class="px-4 py-3">Fecha y Hora</th>
                            <th class="px-4 py-3 text-center">Total</th>
                            <th class="px-4 py-3 text-center">H</th>
                            <th class="px-4 py-3 text-center">M</th>
                            <th class="px-4 py-3">Aula</th>
                            <th class="px-4 py-3">Edificio</th>
                            <th class="px-4 py-3">Archivo</th>
                            <th class="px-4 py-3">Detalles</th>
                            <th class="px-4 py-3 text-center">Acciones</th>
                        </tr>
                    </thead>

                    <tbody class="text-gray-800">

                        @foreach($advisories as $adv)
                            @php
                                $students = $adv->advisoryDetail->students ?? collect();

                                // Formato de fechas
                                $startDate = \Carbon\Carbon::parse($adv->start_date)->format('d/m/Y');
                                $endDate = \Carbon\Carbon::parse($adv->end_date)->format('d/m/Y');

                                // Formato de horas
                                $startTime = \Carbon\Carbon::parse($adv->start_time)->format('H:i');
                                $endTime = \Carbon\Carbon::parse($adv->end_time)->format('H:i');
                            @endphp

                            <tr class="border-b hover:bg-gray-100 transition">

                                <td class="px-4 py-3">
                                    {{ $adv->teacherSubject->teacher->name }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $adv->teacherSubject->subject->career->name }}
                                </td>

                                <td class="px-4 py-3">
                                    {{ $adv->teacherSubject->subject->name }}
                                </td>

                                <td class="px-4 py-3 font-semibold">{{ $startDate }}</td>

                                <td class="px-4 py-3 font-semibold">{{ $endDate }}</td>
                                
                                 <td class="px-4 py-3 font-semibold">
                                    
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
                                           class="text-blue-600 underline hover:text-blue-800">
                                            Ver archivo
                                        </a>
                                    @else
                                        <span class="text-gray-500">Sin archivo</span>
                                    @endif
                                </td>

                                <td class="px-4 py-3 text-center">
                                    <a href="{{ route('basic_sciences.advisories.details', $adv->advisory_id) }}"
                                       class="text-indigo-600 font-medium hover:text-indigo-800">
                                        Ver detalles</a>
                                </td>

                                <td class="px-4 py-3 flex gap-3 justify-center">

                                    <!-- Editar -->
                                    <a href="{{ route('basic_sciences.advisories.edit', $adv->advisory_id) }}"
                                       class="text-white font-semibold px-3 py-1 rounded hover:opacity-90"
                                       style="background-color:#F39C12;">
                                        Editar
                                    </a>

                                    <!-- ELIMINAR CON MODAL -->
                                    <button 
                                        onclick="openDeleteModal('{{ $adv->teacherSubject->subject->name }}', '{{ $adv->advisory_id }}')"
                                        class="text-white font-semibold px-3 py-1 rounded hover:opacity-90"
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

    <!-- FOOTER -->
    <div class="fixed bottom-0 left-0 w-full z-40 shadow">
        <x-basic-sciences-footer />
    </div>


    <!-- MODAL ELIMINACIÓN -->
    <div id="deleteModal"
         class="hidden fixed inset-0 bg-black bg-opacity-40 backdrop-blur-sm flex items-center justify-center z-50">

        <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-md">

            <h2 class="text-xl font-bold text-red-600 mb-3">⚠ Confirmar eliminación</h2>

            <p class="text-gray-700 mb-4">
                ¿Seguro que deseas eliminar la asesoría de:
                <strong id="advisoryName"></strong>?
                <br>Esta acción no se puede deshacer.
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
                        Sí, eliminar
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

