<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asesorías</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen p-6">

    <div class="max-w-7xl mx-auto bg-white shadow-lg rounded-xl p-8">

        {{-- Header --}}
        <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between mb-8">
            <h1 class="text-3xl font-extrabold text-gray-800">📚 Asesorías Registradas</h1>

            <div class="flex flex-col sm:flex-row gap-3 mt-4 sm:mt-0">
                <a href="{{ route('basic_sciences.advisory_details.index') }}"
                   class="text-green-600 hover:text-green-800 font-medium">
                    → Ver Detalles de Asesoría
                </a>

                <a href="{{ route('basic_sciences.index') }}"
                   class="text-green-600 hover:text-green-800 font-medium">
                    Regresar al inicio
                </a>
            </div>
        </div>

        {{-- Buscador --}}
        <form method="GET" class="mb-6 flex gap-3">
            <input 
                type="text"
                name="q"
                placeholder="Buscar por maestro o materia..."
                value="{{ request('q') }}"
                class="border border-gray-300 rounded-lg px-4 py-2 w-72 focus:ring-2 focus:ring-blue-500 focus:outline-none"
            >
            
            <button
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Buscar
            </button>
        </form>

        {{-- Tabla --}}
        <div class="overflow-x-auto rounded-xl border border-gray-300 shadow">
            <table class="min-w-full border-collapse text-sm">

                {{-- ENCABEZADOS --}}
                <thead class="bg-gray-100 text-gray-700 uppercase text-xs font-semibold">
                    <tr class="border-b">
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Maestro</th>
                        <th class="px-4 py-3">Carrera</th>
                        <th class="px-4 py-3">Materia</th>
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

                {{-- CUERPO --}}
                <tbody class="text-gray-700">

                    @foreach($advisories as $adv)
                        @php
                            $students = $adv->advisoryDetail->students ?? collect();
                            $total = $students->count();
                            $hombres = $students->where('gender', 'Masculino')->count();
                            $mujeres = $students->where('gender', 'Femenino')->count();
                        @endphp

                        <tr class="border-b hover:bg-gray-50 transition">

                            <td class="px-4 py-3 font-medium">{{ $adv->advisory_id }}</td>

                            <td class="px-4 py-3">
                                {{ $adv->teacherSubject->teacher->name }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $adv->teacherSubject->subject->career->name }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $adv->teacherSubject->subject->name }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $adv->schedule }}
                            </td>

                            <td class="px-4 py-3 text-center font-semibold">{{ $total }}</td>

                            <td class="px-4 py-3 text-center text-blue-600 font-semibold">
                                {{ $hombres }}
                            </td>

                            <td class="px-4 py-3 text-center text-pink-600 font-semibold">
                                {{ $mujeres }}
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
                                    Ver detalles
                                </a>
                            </td>

                            <td class="px-4 py-3 flex gap-3 justify-center">

                                {{-- Editar --}}
                                <a href="{{ route('basic_sciences.advisories.edit', $adv->advisory_id) }}"
                                   class="text-blue-600 font-semibold hover:text-blue-800">
                                    Editar
                                </a>

                                {{-- Eliminar --}}
                                <form action="{{ route('basic_sciences.advisories.destroy', $adv->advisory_id) }}"
                                      method="POST"
                                      onsubmit="return confirm('¿Eliminar asesoría?')">
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        class="text-red-600 font-semibold hover:text-red-800">
                                        Eliminar
                                    </button>
                                </form>

                            </td>

                        </tr>
                    @endforeach

                </tbody>

            </table>
        </div>
    </div>

</body>
</html>
