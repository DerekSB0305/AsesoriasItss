<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Asesorías de Maestros de mi Carrera</title>
    @vite('resources/css/app.css')
</head>

<body class="bg-gray-100 min-h-screen flex flex-col">

<x-basic-sciences-navbar />

<div class="max-w-6xl mx-auto bg-white shadow-lg rounded-xl p-8 my-10">

    <h1 class="text-3xl font-bold text-[#0B3D7E] mb-6">
        🧩 Asesorías de Maestros de mi Carrera
    </h1>

    <div class="overflow-x-auto">
        <table class="w-full border-collapse shadow">

            <thead style="background-color:#0B3D7E;" class="text-white font-bold">
                <tr>
                    <th class="px-4 py-3 text-left">Materia</th>
                    <th class="px-4 py-3 text-left">Maestro</th>
                    <th class="px-4 py-3 text-left">Alumnos</th>
                    <th class="px-4 py-3 text-left">Fecha</th>
                    <th class="px-4 py-3 text-left">Estado</th>
                </tr>
            </thead>

            <tbody class="text-gray-700">

                @foreach ($advisories as $a)
                <tr class="border-b hover:bg-gray-50 transition">

                    <td class="px-4 py-3">
                        {{ $a->teacherSubject->subject->name }}
                    </td>

                    <td class="px-4 py-3">
                        {{ $a->teacherSubject->teacher->name }}
                        {{ $a->teacherSubject->teacher->last_name_f }}
                    </td>

                    <td class="px-4 py-3">
                        <ul class="list-disc ml-5">
                            @foreach($a->advisoryDetail->students as $s)
                                <li>{{ $s->enrollment }} - {{ $s->name }}</li>
                            @endforeach
                        </ul>
                    </td>

                    <td class="px-4 py-3">
                        {{ \Carbon\Carbon::parse($a->schedule)->format('d/m/Y H:i') }}
                    </td>

                    <td class="px-4 py-3 font-semibold">
                        {{ $a->status }}
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
