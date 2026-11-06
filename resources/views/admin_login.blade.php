<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Iniciar sesión | Universidad</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      background-color: #f5f5f5;
      padding: 30px;
      display: flex;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
    }

    .login-container {
      background-color: white;
      padding: 30px 40px;
      border-radius: 10px;
      box-shadow: 0 0 15px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 400px;
      text-align: center;
    }

    h2 {
      color: #003d1a;
      margin-bottom: 20px;
    }

    input {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border-radius: 6px;
      border: 1px solid #ccc;
    }

    button {
      background-color: #002c6d;
      color: white;
      font-weight: bold;
      border: none;
      padding: 12px;
      border-radius: 6px;
      width: 100%;
      cursor: pointer;
      transition: background-color 0.3s;
    }

    button:hover {
      background-color: #003d1a;
    }

    .error, .success {
      margin-top: 10px;
      font-weight: bold;
    }

    .error {
      color: #a00;
    }

    .success {
      color: green;
    }

    .volver-btn {
      margin-top: 20px;
      display: inline-block;
      padding: 10px 20px;
      background-color: #ccc;
      color: #003d1a;
      font-weight: bold;
      border-radius: 6px;
      text-decoration: none;
      transition: background-color 0.3s;
    }

    .volver-btn:hover {
      background-color: #bbb;
    }
  </style>
</head>
<body>

  <div class="login-container">
    <h2>Inicio de sesión<br>Administrador</h2>

    @if(session('error'))
      <div class="error">{{ session('error') }}</div>
    @endif

    @if(session('success'))
      <div class="success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.login.post') }}">
      @csrf
      <input type="text" name="nombre" placeholder="Nombre completo" required>
      <input type="password" name="contrasena" placeholder="Contraseña" required>
      <button type="submit">Entrar</button>
    </form>

    <!-- Botón para volver a la vista inicio -->
    <a href="{{ route('inicio') }}" class="volver-btn">← Regresar al inicio</a>
  </div>

</body>
</html>
