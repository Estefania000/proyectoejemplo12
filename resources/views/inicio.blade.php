<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <title>Universidad | Inicio</title>
  <style>
    body {
      height: 100vh;
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #ffffff;
      background-image:
        radial-gradient(circle at 15% 25%, rgba(255, 209, 0, 0.25) 0%, transparent 80%),
        radial-gradient(circle at 85% 75%, rgba(0, 89, 42, 0.25) 0%, transparent 80%),
        radial-gradient(circle at 50% 90%, rgba(255, 209, 0, 0.15) 0%, transparent 80%);
      background-repeat: no-repeat;
      background-size: cover;
      display: flex;
      flex-direction: column;
      align-items: center;
    }

    /* Encabezado con logo a la izquierda y texto centrado */
    .encabezado {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 100%;
      margin-top: 30px;
      position: relative;
    }

    .encabezado img {
      position: absolute;
      left: 40px;
      width: 160px;
    }

    .titulo {
      text-align: center;
      font-size: 2.2rem;
      color: #002c6d;
      font-weight: bold;
    }

    .barras-colores {
      display: flex;
      height: 20px;
      width: 500px;
      margin: 10px auto;
      overflow: hidden;
      border-radius: 6px;
    }

    /* Colores invertidos */
    .dorado { flex: 1; background-color: #ffd100; }
    .azul { flex: 1; background-color: #002c6d; }

    .btn-container {
      margin-top: 60px;
      display: flex;
      justify-content: center;
      flex-wrap: wrap;
      gap: 80px;
    }

    .btn-cuadro {
      width: 220px;
      height: 220px;
      background: #ffffff;
      border-radius: 15px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.15);
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      transition: transform 0.3s, box-shadow 0.3s;
      cursor: pointer;
      text-decoration: none;
      color: #003d1a;
    }

    .btn-cuadro:hover {
      transform: scale(1.08);
      box-shadow: 0 10px 20px rgba(0,0,0,0.25);
    }

    .btn-cuadro span.emoji {
      font-size: 70px;
      margin-bottom: 12px;
    }

    .btn-cuadro span.label {
      font-size: 1.3rem;
      font-weight: bold;
      text-align: center;
    }

  </style>
</head>
<body>

  <!-- Encabezado con logo y título -->
  <div class="encabezado">
    <img src="{{ asset('images/logotipo.png') }}" alt="Logo Universidad">
    <div>
      <div class="titulo">
        Solicitud de préstamos de equipo universitario<br>Universidad
      </div>
      <div class="barras-colores">
        <div class="dorado"></div>
        <div class="azul"></div>
      </div>
    </div>
  </div>

  <!-- Botones de acceso -->
  <div class="btn-container">
    <a href="{{ route('admin') }}" class="btn-cuadro">
      <span class="emoji">🛠️</span>
      <span class="label">Administrador</span>
    </a>

    <a href="{{ route('alumno') }}" class="btn-cuadro">
      <span class="emoji">🎒</span>
      <span class="label">Alumnos</span>
    </a>
  </div>

</body>
</html>
