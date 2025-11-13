<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Solicitar Asesoría</title>
</head>
<body style="font-family:Arial; max-width:900px; margin:40px auto;">

    <h2>Solicitar Asesoría</h2>

    <form action="{{ route('teachers.requests.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        <div style="margin-bottom:15px;">
                <label>Alumnos:</label>
    <select name="enrollments[]" multiple size="6" class="w-full border rounded p-2" required>
        @foreach($students as $s)
            <option value="{{ $s->enrollment }}">
                {{ $s->enrollment }} — {{ $s->name }} {{ $s->last_name_f }}
            </option>
        @endforeach
    </select>
    <p style="color: blue; font-weight: bold;">
        * Mantén presionado CTRL para seleccionar varios alumnos
    </p>

        </div>

        <div style="margin-bottom:15px;">
            <label><strong>Materia:</strong></label><br>
            <select name="subject_id" required style="width:100%; padding:6px;">
                @foreach($subjects as $sub)
                    <option value="{{ $sub->subject_id }}">{{ $sub->name }}</option>
                @endforeach
            </select>
            @error('subject_id')
                <small style="color:red">{{ $message }}</small>
            @enderror
        </div>

        <div style="margin-bottom:15px;">
            <label><strong>Motivo / detalle de la asesoría:</strong></label><br>
            <textarea name="reason" rows="4" placeholder="Explica por qué solicitas esta asesoría" style="width:100%; padding:6px;">{{ old('reason') }}</textarea>
            @error('reason')
                <small style="color:red">{{ $message }}</small>
            @enderror
        </div>

        <div style="margin-bottom:15px;">
            <label><strong>Hoja de canalización (PDF/JPG/PNG, máx. 2MB)</strong></label><br>
            <input type="file" name="canalization_file" accept=".pdf,.jpg,.jpeg,.png">
            @error('canalization_file')
                <small style="color:red">{{ $message }}</small>
            @enderror
        </div>

        <button type="submit" style="padding:8px 14px; background:#1e88e5; color:#fff; border:0; border-radius:4px;">
            Enviar Solicitud
        </button>

    </form>

</body>
</html>
