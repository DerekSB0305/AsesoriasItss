<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Solicitudes</title>
</head>
<body>
    <h1>Lista de Solicitudes</h1>
    <table border="1">
        <thead>
            <tr>
                <th>Matricula</th>
                <th>nombre estudiante</th>
                <th>apellido paterno</th>
                <th>apellido materno</th>
                <th>carrera</th>
                <th>semestre</th>
                <th>grupo</th>
                <th>Asunto</th>
                <th>Materias solicitada</th>
                <th>Tutor</th>
                <th>Hoja de canalizacion</th>
                <th>Accion</th>
            </tr>
        </thead>
       <tbody>
    @foreach ($requests as $request)
        <tr>
            <td>{{ $request->student->enrollment }}</td>
            <td>{{ $request->student->name }}</td>
            <td>{{ $request->student->last_name_f }}</td>
            <td>{{ $request->student->last_name_m }}</td>
            <td>{{ $request->student->career->name ?? 'N/A' }}</td>
            <td>{{ $request->student->semester }}</td>
            <td>{{ $request->student->group ?? 'N/A' }}</td>
            <td>{{ $request->reason }}</td>
            <td>{{ $request->subject->name }}</td> {{-- o si tienes otro campo diferente --}}
            <td>{{ $request->teacher->name ?? 'N/A' }}</td>

            <td>
                @if($request->canalization_file)
                    <a href="{{ asset('storage/' . $request->canalization_file) }}" target="_blank">Ver Hoja</a>
                @else
                    No disponible
                @endif
            </td>
            <td>
                {{-- <a href="{{ route('teachers.advisories.create', $request->request_id) }}"class="bg-blue-600 text-white px-3 py-1 rounded">Crear asesoría</a> --}}
            </td>
        </tr>
    @endforeach
</tbody>

    </table>
</body>
</html>