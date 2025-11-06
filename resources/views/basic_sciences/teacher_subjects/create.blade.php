<form action="{{ route('basic_sciences.teacher_subjects.store') }}" method="POST">
    @csrf

    <label>Maestro:</label>
    <select name="teacher_user" required>
        @foreach($teachers as $t)
            <option value="{{ $t->teacher_user }}">
                {{ $t->name }} {{ $t->last_name_f }} {{ $t->last_name_m }}
            </option>
        @endforeach
    </select>

    <br><br>

    <table border="1" cellpadding="5">
        <thead>
            <tr>
                <th>Materia</th>
                <th>Carrera</th>
            </tr>
        </thead>

        <tbody>
            @foreach($subjects as $subject)
                <tr>
                    <td>
                        <input type="checkbox" name="subjects[{{ $subject->subject_id }}][subject_id]" value="{{ $subject->subject_id }}">
                        {{ $subject->name }}
                    </td>

                    <td>
                        <select name="subjects[{{ $subject->subject_id }}][career_id]">
                            @foreach($careers as $career)
                                <option value="{{ $career->career_id }}">{{ $career->name }}</option>
                            @endforeach
                        </select>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <br>
    <button type="submit">Guardar</button>
</form>
