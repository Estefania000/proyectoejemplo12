<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Reporte en Excel</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f8f9fa;
            padding: 30px;
        }
        h1 {
            color: #333;
        }
        form {
            background-color: #fff;
            padding: 20px;
            border: 2px solid #28a745;
            border-radius: 10px;
            max-width: 400px;
            margin: 0 auto;
        }
        label {
            display: block;
            margin-top: 15px;
            font-weight: bold;
        }
        input[type="number"],
        select {
            width: 100%;
            padding: 8px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }
        button {
            margin-top: 20px;
            padding: 10px 15px;
            background-color: #28a745;
            border: none;
            color: white;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
        }
        button:hover {
            background-color: #218838;
        }
        .regresar {
            text-align: center;
            margin-top: 20px;
        }
        .regresar a {
            color: #007bff;
            text-decoration: none;
        }
        .regresar a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

    <h1>Descargar reporte en Excel</h1>

    <form action="{{ route('admin.descargarExcel') }}" method="GET">
        @csrf
        <label for="anio">Año:</label>
        <input type="number" name="anio" id="anio" value="{{ date('Y') }}" required>

        <label for="semestre">Periodo:</label>
        <select name="semestre" id="semestre" required>
            <option value="A">A (Febrero - Julio)</option>
            <option value="B">B (Agosto - Enero)</option>
        </select>

        <button type="submit">Descargar Excel</button>
    </form>

    <div class="regresar">
        <a href="{{ route('admin') }}">← Regresar al panel</a>
    </div>

</body>
</html>
