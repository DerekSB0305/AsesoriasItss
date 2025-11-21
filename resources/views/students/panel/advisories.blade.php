<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Asesorías</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">
    <x-students-navbar/>
     <div class="flex-grow p-6">

<div class="max-w-5xl mx-auto bg-white p-8 shadow-xl rounded-2xl">

    <a href="{{ route('students.panel.index') }}"
       class="text-indigo-600 hover:text-indigo-800 text-sm">
        ← Regresar al panel
    </a>

    <h1 class="text-3xl font-bold text-gray-800 mt-4 mb-6">
        🧑‍🏫 Mis Asesorías Asignadas
    </h1>

    @if ($advisories->count() == 0)
        <p class="text-center text-gray-600 text-lg">
            Aún no tienes asesorías asignadas.
        </p>
    @else

        <div class="overflow-x-auto">
            <table class="w-full border-collapse shadow rounded-lg">

                <thead class="bg-gray-200 text-gray-700 uppercase text-sm">
                    <tr>
                        <th class="px-4 py-3">Fecha</th>
                        <th class="px-4 py-3">Hora</th>
                        <th class="px-4 py-3">Materia</th>
                        <th class="px-4 py-3">Maestro</th>
                        <th class="px-4 py-3">Estado</th>
                        <th class="px-4 py-3">Aula y edificio</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700">

                    @foreach ($advisories as $adv)

                        @php
                            $date = \Carbon\Carbon::parse($adv->schedule)->format('Y-m-d');
                            $time = \Carbon\Carbon::parse($adv->schedule)->format('H:i');
                        @endphp

                        <tr class="border-b hover:bg-gray-50 transition">

                            <td class="px-4 py-3">{{ $date }}</td>
                            <td class="px-4 py-3">{{ $time }} hrs</td>

                            <td class="px-4 py-3 font-semibold">
                                {{ $adv->teacherSubject->subject->name }}
                            </td>

                            <td class="px-4 py-3">
                                {{ $adv->teacherSubject->teacher->name }}
                                {{ $adv->teacherSubject->teacher->last_name_f }}
                            </td>

                            <td class="px-4 py-3">
                                <span class="px-3 py-1 rounded text-white text-sm
                                    @if($adv->advisoryDetail->status == 'Pending') bg-yellow-500
                                    @elseif($adv->advisoryDetail->status == 'Aprobado') bg-green-600
                                    @else bg-gray-600 @endif">
                                    {{ $adv->advisoryDetail->status }}
                                </span>
                            </td>

                            <td class="px-4 py-3">
                                {{ $adv->classroom ?? '---' }} - {{ $adv->building ?? '---' }}
                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>
        </div>

    @endif

</div>
</div>
<x-basic-sciences-footer />
</body>
</html>
