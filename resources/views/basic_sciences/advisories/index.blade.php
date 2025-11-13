<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Listado de Asesorías</title>
</head>
<body>
<h1>Listado de Asesorías</h1>

@if(session('success'))
    <p style="color:green">{{ session('success') }}</p>
@endif

<table border="1" cellpadding="5">
    <thead>
        <tr>
            <th>ID</th>
            <th>Maestro</th>
            <th>Materia</th>
            <th>Carrera</th>
            <th>Fecha / Hora</th>
            <th>Alumnos</th>
            <th>Archivo</th>
            <th>Acciones</th>
        </tr>
    </thead>
    <tbody>
    @foreach($advisories as $adv)
        <tr>
            <td>{{ $adv->advisory_id }}</td>
            <td>{{ $adv->teacherSubject->teacher->name ?? 'N/A' }}</td>
            <td>{{ $adv->teacherSubject->subject->name ?? 'N/A' }}</td>
            <td>{{ $adv->teacherSubject->career->name ?? 'N/A' }}</td>
            <td>{{ $adv->schedule }}</td>
            <td>
                @if($adv->detail && $adv->detail->students->count())
                    <ul>
                        @foreach($adv->detail->students as $stu)
                            <li>{{ $stu->enrollment }} - {{ $stu->name }}</li>
                        @endforeach
                    </ul>
                @else
                    Sin alumnos
                @endif
            </td>
            <td>
                @if($adv->assignment_file)
                    <a href="{{ asset('storage/'.$adv->assignment_file) }}" target="_blank">Ver archivo</a>
                @else
                    N/A
                @endif
            </td>
            <td>
                <form action="{{ route('basic_sciences.advisories.destroy', $adv) }}" method="POST"
                      onsubmit="return confirm('¿Eliminar asesoría?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit">Eliminar</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
</body>
</html>
