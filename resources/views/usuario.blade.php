<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Agregar Usuario | Universidad</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f5f5f5;
      padding: 30px;
    }

    h1 {
      text-align: center;
      color: #003d1a;
    }

    .form-section {
      background: #fff;
      padding: 30px;
      border-radius: 10px;
      max-width: 600px;
      margin: 30px auto;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }

    label {
      display: block;
      margin-bottom: 5px;
      font-weight: bold;
      color: #003d1a;
    }

    input {
      width: 100%;
      padding: 10px;
      margin-bottom: 15px;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    .btn {
      background-color: #002c6d;
      color: white;
      font-weight: bold;
      border: none;
      padding: 12px;
      width: 100%;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    .btn:hover {
      background-color: #003d1a;
    }

    .volver {
      display: block;
      text-align: center;
      margin-top: 20px;
      color: #002c6d;
      text-decoration: none;
      font-weight: bold;
    }

    .volver:hover {
      text-decoration: underline;
    }

    .usuarios-lista {
      margin-top: 40px;
    }

    .usuarios-lista h2 {
      text-align: center;
      color: #003d1a;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 10px;
      background: white;
    }

    th, td {
      padding: 10px;
      border: 1px solid #ccc;
      text-align: center;
    }

    th {
      background-color: #002c6d;
      color: white;
    }

  </style>
</head>
<body>

  <h1>Agregar Nuevo Usuario</h1>

  <div class="form-section">
    <form method="POST" action="{{ route('admin.guardar_usuario') }}">
      @csrf

      <label for="nombre">Nombre:</label>
      <input type="text" name="nombre" required>

      <label for="app">Apellido Paterno:</label>
      <input type="text" name="app" required>

      <label for="apm">Apellido Materno:</label>
      <input type="text" name="apm" required>

      <label for="escuela">Escuela:</label>
      <input type="text" name="escuela" required>

      <label for="contrasena">Contraseña:</label>
      <input type="password" name="contrasena" required>

      <button type="submit" class="btn">Guardar Usuario</button>
    </form>

    <a href="{{ route('admin') }}" class="volver">← Volver al panel de administración</a>
  </div>

  <!-- Lista de usuarios actuales -->
  <div class="usuarios-lista">
    <h2>Usuarios registrados</h2>
    <table>
      <thead>
        <tr>
          <th>Nombre</th>
          <th>Apellido Paterno</th>
          <th>Apellido Materno</th>
          <th>Escuela</th>
        </tr>
      </thead>
      <tbody>
        @foreach (\App\Models\Usuario::all() as $usuario)
          <tr>
            <td>{{ $usuario->nombre }}</td>
            <td>{{ $usuario->app }}</td>
            <td>{{ $usuario->apm }}</td>
            <td>{{ $usuario->escuela }}</td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>

</body>
</html>
