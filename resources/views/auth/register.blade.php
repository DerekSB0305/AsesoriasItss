<x-guest-layout>
  <form method="POST" action="{{ route('register') }}">
    @csrf
    <label>Usuario:</label>
    <input type="text" name="username" required>

    <label>Contraseña:</label>
    <input type="password" name="password" required>

    <label>Confirmar contraseña:</label>
    <input type="password" name="password_confirmation" required>

    <label>Rol:</label>
    <select name="role_id" required>
        <option value="1">Alumno</option>
        <option value="2">Profesor</option>
        <option value="3">Administrativo</option>
    </select>

    <button type="submit">Registrar</button>
</form>
</x-guest-layout>
