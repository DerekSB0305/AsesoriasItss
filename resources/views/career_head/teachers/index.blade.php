<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Maestros de mi Carrera</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

<x-basic-sciences-navbar />

<div class="max-w-6xl mx-auto bg-white shadow-lg rounded-xl p-8 my-10">

    <h1 class="text-3xl font-bold text-[#0B3D7E] mb-6">
        👨‍🏫 Maestros de mi Carrera
    </h1>

    <div class="overflow-x-auto">
        <table class="w-full border-collapse shadow">

            <thead style="background-color:#0B3D7E;" class="text-white font-bold">
                <tr>
                    <th class="px-4 py-3 text-left">Usuario</th>
                    <th class="px-4 py-3 text-left">Nombre</th>
                    <th class="px-4 py-3 text-left">Apellido Paterno</th>
                    <th class="px-4 py-3 text-left">Apellido Materno</th>
                    <th class="px-4 py-3 text-left">Carrera</th>
                    <th class="px-4 py-3 text-left">Grado</th>
                    <th class="px-4 py-3 text-left">Tutor</th>
                    <th class="px-4 py-3 text-left">Horas CB</th>
                    <th class="px-4 py-3 text-center">Horario</th>
                </tr>
            </thead>

            <tbody class="text-gray-700">

                @foreach ($teachers as $t)
                <tr class="border-b hover:bg-gray-50 transition">

                    <td class="px-4 py-3">{{ $t->teacher_user }}</td>
                    <td class="px-4 py-3">{{ $t->name }}</td>
                    <td class="px-4 py-3">{{ $t->last_name_f }}</td>
                    <td class="px-4 py-3">{{ $t->last_name_m }}</td>
                    <td class="px-4 py-3">{{ $t->career->name ?? 'N/A' }}</td>
                    <td class="px-4 py-3">{{ $t->degree }}</td>
                    <td class="px-4 py-3">{{ $t->tutor ? 'Sí' : 'No' }}</td>
                    <td class="px-4 py-3">{{ $t->science_department ? 'Sí' : 'No' }}</td>

                    <td class="px-4 py-3 text-center">
                        @if($t->schedule)
                            <a href="{{ asset('storage/'.$t->schedule) }}"
                                target="_blank"
                                class="text-blue-600 hover:text-blue-800">
                                📄 Ver
                            </a>
                        @else
                            <span class="text-gray-500">No disponible</span>
                        @endif
                    </td>
                </tr>
                @endforeach

            </tbody>

        </table>
    </div>
</div>

<x-basic-sciences-footer />

</body>
</html>
