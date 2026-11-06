<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>Papeleta de Insumo | Universidad</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      padding: 30px;
      background-color: #fff;
      color: #003d1a;
    }

    h1 {
      text-align: center;
      margin-bottom: 30px;
      color: #002c6d;
    }

    table {
      width: 100%;
      max-width: 700px;
      margin: 0 auto 30px;
      border-collapse: collapse;
      border: 2px solid #002c6d;
      border-radius: 8px;
      overflow: hidden;
    }

    th, td {
      padding: 12px;
      border: 1px solid #002c6d;
      text-align: left;
    }

    th {
      background-color: #002c6d;
      color: white;
      width: 40%;
    }

    td {
      background-color: #f5f5f5;
    }

    .btn-print, .btn-volver {
      display: block;
      width: 200px;
      margin: 20px auto;
      padding: 10px;
      background-color: #002c6d;
      color: white;
      font-weight: bold;
      border: none;
      border-radius: 6px;
      cursor: pointer;
      font-size: 16px;
      text-align: center;
      text-decoration: none;
    }

    .btn-print:hover, .btn-volver:hover {
      background-color: #003d1a;
    }

    @media print {
      .btn-print, .btn-volver {
        display: none;
      }
    }
  </style>
</head>
<body>

  <h1>Papeleta de Insumo</h1>

  <table>
    <tr>
      <th>Nombre</th>
      <td>{{ $insumo->nombre }}</td>
    </tr>
    <tr>
      <th>Número de cuenta</th>
      <td>{{ $insumo->n_cuenta }}</td>
    </tr>
    <tr>
      <th>Aula</th>
      <td>{{ $insumo->aula }}</td>
    </tr>
    <tr>
      <th>Teléfono</th>
      <td>{{ $insumo->tel }}</td>
    </tr>
    <tr>
      <th>Unidad de aprendizaje</th>
      <td>{{ $insumo->unidad_aprendizaje }}</td>
    </tr>
    <tr>
      <th>Profesor</th>
      <td>{{ $insumo->profesor }}</td>
    </tr>
    <tr>
      <th>Licenciatura</th>
      <td>{{ $insumo->licenciatura }}</td>
    </tr>
    <tr>
      <th>Insumo</th>
      <td>{{ $insumo->insumo }}</td>
    </tr>
    <tr>
      <th>Fecha de solicitud</th>
      <td>{{ \Carbon\Carbon::parse($insumo->fecha_solicitud)->format('d/m/Y H:i') }}</td>
    </tr>
    <tr>
      <th>Fecha de entrega</th>
      <td>{{ \Carbon\Carbon::parse($insumo->fecha_entrega)->format('d/m/Y H:i') }}</td>
    </tr>
    <tr>
      <th>Estatus</th>
      <td>{{ $insumo->estatus }}</td>
    </tr>
    <tr>
      <th>Número de insumo</th>
      <td>{{ $insumo->no_insumo ?? 'No asignado' }}</td>
    </tr>
  </table>

  <button class="btn-print" onclick="window.print()">Imprimir Papeleta</button>


</body>
</html>
