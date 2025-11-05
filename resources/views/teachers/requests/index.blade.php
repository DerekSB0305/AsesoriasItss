<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis solicitudes</title>
</head>
<body>

    <h2>Solicitudes de asesoría hechas por mí</h2>

    <a href="{{ route('teachers.requests.create') }}">➕ Nueva solicitud</a>
    <br><br>

    @if ($requests->count() == 0)
        <p>No has solicitado asesorías aún.</p>
    @else
        <table border="1" cellpadding="6">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Alumno</th>
                    <th>Materia</th>
                    <th>Motivo</th>
                    <th>Archivo</th>
                    <th>Fecha</th>
                </tr>
            </thead>
            <tbody>

                @foreach ($requests as $r)
                    <tr>
                        <td>{{ $r->request_id }}</td>

                        <td>
                            {{ $r->student->enrollment }} -
                            {{ $r->student->name }} {{ $r->student->last_name_f }}
                        </td>

                        <td>
                            {{ $r->subject->name }}
                        </td>

                        <td>{{ $r->reason ?? '---' }}</td>

                        <td>
                            @if($r->canalization_file)
                                <a href="{{ asset('storage/'.$r->canalization_file) }}" target="_blank">Ver archivo</a>
                            @else
                                No adjunto
                            @endif
                        </td>

                        <td>{{ $r->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach

            </tbody>
        </table>
    @endif

    <br>
    <form action="{{ route('logout') }}" method="POST">
        @csrf
        <button type="submit">Cerrar sesión</button>
    </form>

</body>
</html>
