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
                    <td>{{ $request->enrollment }}</td>
                    <td>{{ $request->subject }}</td>
                    <td>{{ $request->request_date }}</td>
                    <td>{{ $request->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>