<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asesorías</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen p-6">

    <div class="max-w-6xl mx-auto bg-white shadow-md rounded-xl p-8">

        {{-- Título --}}
        <div class="flex items-center justify-between mb-6">
            <h1 class="text-3xl font-bold text-gray-800">📚 Asesorías Registradas</h1>

            <a href="{{ route('basic_sciences.advisory_details.index') }}"
               class="text-green-600 hover:text-green-800 font-medium">
                → Ver Detalles de Asesoría
            </a>
        </div>

        {{-- Buscador --}}
        <form method="GET" class="mb-6 flex gap-3">
            <input 
                type="text"
                name="q"
                placeholder="Buscar por maestro o materia..."
                value="{{ request('q') }}"
                class="border border-gray-300 rounded-lg px-4 py-2 w-64 focus:ring-2 focus:ring-blue-500 focus:outline-none"
            >
            
            <button
                class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition">
                Buscar
            </button>
        </form>

        {{-- Tabla --}}
        <div class="overflow-x-auto">
            <table class="w-full border-collapse rounded-lg overflow-hidden shadow-sm">
                <thead class="bg-gray-200 text-gray-700 text-sm uppercase">
                    <tr>
                        <th class="px-4 py-3">ID</th>
                        <th class="px-4 py-3">Maestro</th>
                        <th class="px-4 py-3">Materia</th>
                        <th class="px-4 py-3">Fecha y Hora</th>
                        <th class="px-4 py-3 text-center">Total</th>
                        <th class="px-4 py-3 text-center">Hombres</th>
                        <th class="px-4 py-3 text-center">Mujeres</th>
                        <th class="px-4 py-3 text-center">Acciones</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700">

                    @foreach($advisories as $adv)
                        @php
                            $students = $adv->advisoryDetail->students ?? collect();

                            $total = $students->count();
                            $hombres = $students->where('gender', 'Masculino')->count();
                            $mujeres = $students->where('gender', 'Femenino')->count();
                        @endphp

                        <tr class="border-b hover:bg-gray-50 transition">

                            <td class="px-4 py-3">{{ $adv->advisory_id }}</td>

                            <td class="px-4 py-3 font-medium">
                                {{ $adv->teacherSubject->teacher->name }}
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

                            <td class="px-4 py-3 text-center space-x-3">

                                {{-- Editar --}}
                                <a href="{{ route('basic_sciences.advisories.edit', $adv->advisory_id) }}"
                                   class="text-blue-600 font-medium hover:text-blue-800">
                                    Editar
                                </a>

                                {{-- Eliminar --}}
                                <form action="{{ route('basic_sciences.advisories.destroy', $adv) }}"
                                      method="POST"
                                      class="inline"
                                      onsubmit="return confirm('¿Eliminar asesoría?')">

                                    @csrf
                                    @method('DELETE')

                                    <button 
                                        class="text-red-600 font-medium hover:text-red-800">
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

