<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Registrar Usuario</title>
  @vite('resources/css/app.css')
</head>
<body class="bg-gray-100 min-h-screen">
  <div class="max-w-xl mx-auto mt-10 bg-white p-6 rounded-lg shadow">
    <h1 class="text-2xl font-bold mb-4">Registrar Usuario</h1>

    @if ($errors->any())
      <div class="mb-4 p-3 bg-red-100 text-red-700 rounded">
        <ul class="list-disc pl-5">
          @foreach ($errors->all() as $error)
            <li>{{ $error }}</li>
          @endforeach
        </ul>
      </div>
    @endif

    <form method="POST" action="{{ route('register') }}" class="space-y-4">
      @csrf

      <div>
        <label class="block font-medium mb-1">Rol</label>
        <select id="role_id" name="role_id" class="w-full border rounded p-2" required>
          <option value="">Seleccione un rol</option>
          @foreach($roles as $role)
            <option value="{{ $role->id }}" @selected(old('role_id')==$role->id)>{{ $role->role_type }}</option>
          @endforeach
        </select>
      </div>

      {{-- Identificador: cambia según el rol --}}
      <div id="field-student" class="hidden">
        <label class="block font-medium mb-1">Matrícula (Alumno)</label>
        <select class="w-full border rounded p-2" data-source="student">
          <option value="">Seleccione una matrícula</option>
          @foreach($students as $s)
            <option value="{{ $s->enrollment }}">{{ $s->enrollment }}</option>
          @endforeach
        </select>
      </div>

      <div id="field-teacher" class="hidden">
        <label class="block font-medium mb-1">Usuario de Profesor</label>
        <select class="w-full border rounded p-2" data-source="teacher">
          <option value="">Seleccione usuario de profesor</option>
          @foreach($teachers as $t)
            <option value="{{ $t->teacher_user }}">{{ $t->teacher_user }}</option>
          @endforeach
        </select>
      </div>

      <div id="field-admin" class="hidden">
        <label class="block font-medium mb-1">Usuario Administrativo (Ciencias Básicas/Jefatura)</label>
        <select class="w-full border rounded p-2" data-source="admin">
          <option value="">Seleccione usuario administrativo</option>
          @foreach($administratives as $a)
            <option value="{{ $a->administrative_user }}">{{ $a->administrative_user }}</option>
          @endforeach
        </select>
      </div>

      {{-- Campo real que se envía (rellenado por JS) --}}
      <input type="hidden" name="user" id="user_value" value="{{ old('user') }}">

      <div>
        <label class="block font-medium mb-1">Contraseña</label>
        <input type="password" name="password" class="w-full border rounded p-2" required>
      </div>

      <div>
        <label class="block font-medium mb-1">Confirmar contraseña</label>
        <input type="password" name="password_confirmation" class="w-full border rounded p-2" required>
      </div>

      <button class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">Crear usuario</button>
    </form>
  </div>

  <script>
    const roleSelect = document.getElementById('role_id');
    const userValue  = document.getElementById('user_value');

    const boxStudent = document.getElementById('field-student');
    const boxTeacher = document.getElementById('field-teacher');
    const boxAdmin   = document.getElementById('field-admin');

    const mapBoxes = {
      'alumno': boxStudent,
      'profesor': boxTeacher,
      'ciencias básicas': boxAdmin,
      'jefatura': boxAdmin,
      'administrativo': boxAdmin,
    };

    function normalize(str) {
      return (str || '').toLowerCase().normalize('NFD').replace(/[\u0300-\u036f]/g, '');
    }

    function hideAll() {
      [boxStudent, boxTeacher, boxAdmin].forEach(el => el.classList.add('hidden'));
      userValue.value = '';
    }

    function bindSelects() {
      document.querySelectorAll('[data-source="student"],[data-source="teacher"],[data-source="admin"]').forEach(sel => {
        sel.addEventListener('change', e => {
          if (e.target.value) userValue.value = e.target.value;
        });
      });
    }

    roleSelect.addEventListener('change', e => {
      hideAll();
      const selectedText = normalize(e.target.options[e.target.selectedIndex]?.text);
      // Muestra el select correcto
      for (const key in mapBoxes) {
        if (normalize(key) === selectedText) {
          mapBoxes[key].classList.remove('hidden');
          break;
        }
      }
    });

    bindSelects();
  </script>
</body>
</html>
