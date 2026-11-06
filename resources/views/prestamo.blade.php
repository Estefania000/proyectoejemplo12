<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Solicitud de Préstamo de Insumo Informático | Universidad</title>
  <style>
    body {
      margin: 0;
      font-family: Arial, sans-serif;
      background-color: #ffffff;
      background-image:
        radial-gradient(circle at 15% 25%, rgba(0, 89, 42, 0.25) 0%, transparent 80%),
        radial-gradient(circle at 85% 75%, rgba(255, 209, 0, 0.25) 0%, transparent 80%);
      background-repeat: no-repeat;
      background-size: cover;
      display: flex;
      flex-direction: column;
      align-items: center;
      padding: 30px;
    }

    .encabezado {
      display: flex;
      align-items: center;
      justify-content: center;
      width: 100%;
      position: relative;
      margin-bottom: 20px;
    }

    .encabezado img {
      position: absolute;
      left: 30px;
      width: 140px;
    }

    .titulo {
      text-align: center;
      font-size: 2rem;
      color: #002c6d;
      font-weight: bold;
    }

    .barras-colores {
      display: flex;
      height: 20px;
      width: 400px;
      margin: 10px auto;
      border-radius: 6px;
      overflow: hidden;
    }

    .dorado { flex: 1; background-color: #ffd100; }
    .azul { flex: 1; background-color: #002c6d; }

    /* Cuadro formulario más llamativo */
    form {
      padding: 20px 30px;
      max-width: 700px;
      width: 100%;
      display: flex;
      flex-direction: column;
      gap: 20px;
      border: 3px solid #002c6d;
      background: rgba(255, 255, 255, 0.85);
      border-radius: 10px;
      box-shadow: 0px 4px 15px rgba(0, 89, 42, 0.3);
      box-sizing: border-box;
    }

    label {
      font-weight: normal;
      color: #003d1a;
      font-size: 0.95rem;
      display: block;
    }

    input, select {
      width: 100%;
      padding: 10px 12px;
      margin-top: 6px;
      border: 2px solid #002c6d;
      background: transparent;
      font-size: 1rem;
      transition: border-color 0.3s, box-shadow 0.3s, transform 0.2s;
      color: #003d1a;
      border-radius: 4px;
      box-sizing: border-box;
    }

    input::placeholder {
      color: #888;
    }

    input:focus, select:focus {
      outline: none;
      border-color: #003d1a;
      box-shadow: 0 0 8px rgba(0, 89, 42, 0.4);
      transform: scale(1.02);
    }

    .fila {
      display: flex;
      gap: 20px;
    }

    .fila input {
      flex: 1;
    }

    /* Grupo checkboxes insumos */
    .checkbox-grupo {
      display: flex;
      flex-wrap: wrap;
      gap: 15px;
      margin-top: 6px;
    }
    .checkbox-grupo label {
      display: flex;
      align-items: center;
      gap: 6px;
      font-size: 0.95rem;
      cursor: pointer;
      color: #003d1a;
    }
    .checkbox-grupo input[type="checkbox"] {
      cursor: pointer;
    }

    #campo_otro {
      margin-top: 8px;
      overflow: hidden;
      max-height: 0;
      opacity: 0;
      transition: max-height 0.4s ease, opacity 0.4s ease;
    }

    #campo_otro.visible {
      max-height: 50px;
      opacity: 1;
    }

    .leyenda {
      margin-top: 10px;
      font-size: 0.95rem;
      color: #a00;
      font-weight: bold;
      text-align: center;
    }

    button {
      margin-top: 15px;
      width: 100%;
      background-color: #002c6d;
      color: white;
      padding: 12px;
      font-size: 1rem;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      transition: background-color 0.3s, transform 0.2s;
    }

    button:hover {
      background-color: #003d1a;
      transform: translateY(-2px);
    }

    .btn-regresar {
      margin-top: 15px;
      background-color: #ffd100;
      color: #002c6d;
      border: none;
      padding: 10px;
      width: 200px;
      font-size: 0.95rem;
      border-radius: 6px;
      cursor: pointer;
      align-self: center;
      transition: background-color 0.3s, transform 0.2s;
    }

    .btn-regresar:hover {
      background-color: #e6c200;
      transform: translateY(-2px) scale(1.05);
    }
  </style>
</head>
<body>

  <!-- ENCABEZADO -->
  <div class="encabezado">
    <img src="{{ asset('images/logotipo.png') }}" alt="Logo Universidad" />
    <div>
      <div class="titulo">Solicitud de Préstamo de Insumo Informático</div>
      <div class="barras-colores">
        <div class="dorado"></div>
        <div class="azul"></div>
      </div>
    </div>
  </div>

  <!-- FORMULARIO -->
  <form action="{{ route('alumno.guardar') }}" method="POST">
    @csrf

    <label for="nombre">Nombre del solicitante:</label>
    <input type="text" name="nombre" required />

    <div class="fila">
      <div style="flex: 2;">
        <label for="n_cuenta">Número de cuenta:</label>
        <input type="text" name="n_cuenta" required />
      </div>
      <div style="flex: 1;">
        <label for="aula">Aula:</label>
        <input type="text" name="aula" required />
      </div>
    </div>

    <label for="tel">Teléfono:</label>
    <input type="text" name="tel" required />

    <label for="unidad_aprendizaje">Unidad de aprendizaje:</label>
    <input type="text" name="unidad_aprendizaje" required />

    <label for="profesor">Nombre del profesor:</label>
    <input type="text" name="profesor" required />

    <label>Licenciatura:</label>
    <div class="checkbox-grupo">
      <label><input type="radio" name="licenciatura" value="LPS" required /> LPS</label>
      <label><input type="radio" name="licenciatura" value="LED" /> LED</label>
      <label><input type="radio" name="licenciatura" value="LTS" /> LTS</label>
      <label><input type="radio" name="licenciatura" value="LCFYD" /> LCFYD</label>
    </div>

    <label>Insumos solicitados:</label>
    <div class="checkbox-grupo">
      <label><input type="checkbox" name="insumo[]" value="CABLE-HDMI" onchange="mostrarOtroCheckbox()" /> CABLE-HDMI</label>
      <label><input type="checkbox" name="insumo[]" value="CABLE-RED" onchange="mostrarOtroCheckbox()" /> CABLE-RED</label>
      <label><input type="checkbox" name="insumo[]" value="CABLE-VGA" onchange="mostrarOtroCheckbox()" /> CABLE-VGA</label>
      <label><input type="checkbox" name="insumo[]" value="CONVERTIDOR" onchange="mostrarOtroCheckbox()" /> CONVERTIDOR</label>
      <label><input type="checkbox" name="insumo[]" value="CONTROL" onchange="mostrarOtroCheckbox()" /> CONTROL</label>
      <label><input type="checkbox" name="insumo[]" value="EXTENSIÓN" onchange="mostrarOtroCheckbox()" /> EXTENSIÓN</label>
      <label><input type="checkbox" name="insumo[]" value="BOCINAS" onchange="mostrarOtroCheckbox()" /> BOCINAS</label>
      <label><input type="checkbox" name="insumo[]" value="MIMIO" onchange="mostrarOtroCheckbox()" /> MIMIO</label>
      <label><input type="checkbox" name="insumo[]" value="CAÑON" onchange="mostrarOtroCheckbox()" /> CAÑON</label>
      <label><input type="checkbox" name="insumo[]" value="OTRO" onchange="mostrarOtroCheckbox()" /> OTRO</label>
    </div>

    <div id="campo_otro">
      <input type="text" name="insumo_otro" placeholder="Especificar otro insumo" />
    </div>

    @php
      date_default_timezone_set('America/Mexico_City');
      $now = \Carbon\Carbon::now();
    @endphp

    <label for="fecha_solicitud">Fecha de solicitud:</label>
    <input type="text" name="fecha_solicitud" value="{{ $now->format('Y-m-d H:i') }}" readonly />

    <button type="submit">Enviar solicitud</button>
  </form>

  <button class="btn-regresar" onclick="window.location='{{ route('alumno') }}'">← Regresar</button>

  <script>
    function mostrarOtroCheckbox() {
      const checkboxes = document.querySelectorAll('input[name="insumo[]"]');
      const campoOtro = document.getElementById('campo_otro');
      let otroSeleccionado = false;
      checkboxes.forEach(cb => {
        if (cb.value === 'OTRO' && cb.checked) otroSeleccionado = true;
      });
      campoOtro.classList.toggle('visible', otroSeleccionado);
    }
  </script>

</body>
</html>
