<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Asesorías</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

<x-students-navbar/>

<div class="flex-grow p-4 sm:p-6">

<div class="max-w-5xl mx-auto bg-white p-4 sm:p-8 shadow-xl rounded-2xl">

    <a href="{{ route('students.panel.index') }}"
       class="text-indigo-600 hover:text-indigo-800 text-sm">
        ← Regresar al panel
    </a>

    <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 mt-4 mb-6">
        🧑‍🏫 Mis Asesorías Asignadas
    </h1>

    @if ($advisories->count() == 0)

        <p class="text-center text-gray-600 text-lg">
            Aún no tienes asesorías asignadas.
        </p>

    @else

        <div class="overflow-x-auto rounded-lg border">

            <table class="w-full border-collapse">

                <thead class="text-white text-xs sm:text-sm uppercase font-semibold" style="background-color:#0B3D7E;">
                    <tr>
                        <th class="px-3 py-3">Periodo</th>
                        <th class="px-3 py-3">Horario</th>
                        <th class="px-3 py-3">Materia</th>
                        <th class="px-3 py-3">Maestro</th>
                        <th class="px-3 py-3">Estado</th>
                        <th class="px-3 py-3">Aula</th>
                        <th class="px-3 py-3">Edificio</th>
                        <th class="px-3 py-3 text-center">Evaluación</th>
                    </tr>
                </thead>

                <tbody class="text-gray-700 text-sm sm:text-base">

                @foreach ($advisories as $adv)

                    @php
                        $startDate = \Carbon\Carbon::parse($adv->start_date)->format('d/m/Y');
                        $endDate = \Carbon\Carbon::parse($adv->end_date)->format('d/m/Y');

                        $startTime = \Carbon\Carbon::parse($adv->start_time)->format('H:i');
                        $endTime = \Carbon\Carbon::parse($adv->end_time)->format('H:i');

                        $day = ucfirst($adv->day_of_week);

                        $alreadyEvaluated = \App\Models\Evaluation::where('enrollment', auth()->user()->user)
                            ->where('advisory_id', $adv->advisory_id)
                            ->exists();
                    @endphp

                    <tr class="border-b hover:bg-gray-50 transition">

                        <!-- PERIODO -->
                        <td class="px-3 py-3 font-semibold whitespace-nowrap">
                            📅 {{ $startDate }} <br>— {{ $endDate }}
                        </td>

                        <!-- HORARIO -->
                        <td class="px-3 py-3 font-semibold whitespace-nowrap">
                            🕒 {{ $day }}<br>
                            {{ $startTime }} - {{ $endTime }}
                        </td>

                        <!-- MATERIA -->
                        <td class="px-3 py-3 font-semibold">
                            {{ $adv->teacherSubject->subject->name }}
                        </td>

                        <!-- MAESTRO -->
                        <td class="px-3 py-3 whitespace-nowrap">
                            {{ $adv->teacherSubject->teacher->name }}
                            {{ $adv->teacherSubject->teacher->last_name_f }}
                            {{ $adv->teacherSubject->teacher->last_name_m }}
                        </td>

                        <!-- ESTADO -->
                        <td class="px-3 py-3">
                            <span class="px-3 py-1 rounded text-white text-xs sm:text-sm 
                                @if($adv->advisoryDetail->status == 'Pendiente') bg-yellow-500
                                @elseif($adv->advisoryDetail->status == 'Aprobado') bg-green-600
                                @elseif($adv->advisoryDetail->status == 'Finalizado') bg-red-600
                                @else bg-gray-500 @endif">
                                {{ $adv->advisoryDetail->status }}
                            </span>
                        </td>

                        <!-- AULA -->
                        <td class="px-3 py-3">
                            {{ $adv->classroom ?? '---' }}
                        </td>

                        <!-- EDIFICIO -->
                        <td class="px-3 py-3">
                            {{ $adv->building ?? '---' }}
                        </td>

                        <!-- EVALUACIÓN -->
                        <td class="px-3 py-3 text-center">

                            @if($adv->advisoryDetail->status === 'Finalizado')

                                @if($alreadyEvaluated)

                                    <span class="text-green-600 font-bold text-lg">
                                        ✔ Evaluado
                                    </span>

                                @else

                                    <a href="{{ route('students.panel.evaluate', $adv->advisory_id) }}"
                                       class="inline-block px-4 py-2 text-xs sm:text-sm 
                                              bg-[#0B3D7E] text-white rounded-full 
                                              hover:bg-blue-900 transition shadow">
                                        📝 Evaluar
                                    </a>

                                @endif

                            @else
                                <span class="text-gray-400 text-sm">
                                    — No disponible —
                                </span>
                            @endif

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
