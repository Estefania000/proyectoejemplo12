<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Administrador | Universidad</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f0f0f0;
            margin: 20px;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .section {
            display: flex;
            gap: 20px;
        }
        .card {
            flex: 1;
            padding: 15px;
            border: 1px solid green;
            border-radius: 10px;
            background: #fff;
            max-height: 90vh;
            overflow-y: auto;
        }
        .registro {
            border-bottom: 1px dashed green;
            margin-bottom: 10px;
            padding-bottom: 10px;
            font-size: 14px;
        }
        .registro p {
            margin: 2px 0;
        }
        label {
            font-weight: bold;
        }
        select, input[type="date"], input[type="text"] {
            width: 100%;
            margin: 5px 0;
            padding: 4px;
            border: 1px solid green;
            border-radius: 4px;
        }
        button {
            background: green;
            color: white;
            border: none;
            padding: 5px 10px;
            border-radius: 5px;
            margin-top: 5px;
            cursor: pointer;
        }
        button.devolver {
            background: red;
        }
        button.guardar {
            background: blue;
            margin-left: 5px;
        }
        .top-button {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            gap: 10px;
        }
        .estado {
            font-weight: bold;
            font-size: 12px;
            padding: 2px 6px;
            border-radius: 3px;
            display: inline-block;
        }
        .tiempo {
            color: green;
            border: 1px solid green;
        }
        .deuda {
            color: orange;
            border: 1px solid orange;
        }
        .devuelto {
            color: gray;
            border: 1px solid gray;
        }
        .inline-form {
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }
    </style>
</head>
<body>

    <div class="top-button">
        @php
            $usuarioAutenticado = session('usuario_nombre');
        @endphp

        @if ($usuarioAutenticado === 'jorge higinio enriquez miraflor')
            <a href="{{ route('admin.usuario') }}">
                <button>Usuarios</button>
            </a>
        @endif

        <a href="{{ route('admin.excelVista') }}">
            <button>Ir a vista Excel</button>
        </a>

        <form method="POST" action="{{ route('admin.logout') }}">
            @csrf
            <button type="submit">Cerrar sesión</button>
        </form>
    </div>

    <h2>Panel de Administrador</h2>

    <div class="section">
        {{-- SOLICITUDES PENDIENTES --}}
        <div class="card">
            <h3>Solicitudes Pendientes</h3>
            @forelse($solicitudesPendientes as $solicitud)
                <div class="registro">
                    <p><strong>Nombre:</strong> {{ $solicitud->nombre }}</p>
                    <p><strong>No. Cuenta:</strong> {{ $solicitud->n_cuenta }}</p>
                    <p><strong>Aula:</strong> {{ $solicitud->aula }}</p>
                    <p><strong>Licenciatura:</strong> {{ $solicitud->licenciatura }}</p>
                    <p><strong>Unidad:</strong> {{ $solicitud->unidad_aprendizaje }}</p>
                    <p><strong>Profesor:</strong> {{ $solicitud->profesor }}</p>

                    <form method="POST" action="{{ route('admin.guardarNumerosInsumos', $solicitud->id) }}">
                        @csrf
                        <label>Fecha de Entrega:</label>
                        <input type="date" name="fecha_entrega" required>

                        @foreach($solicitud->insumos as $item)
                            <label>Número de {{ strtoupper($item->tipo) }}:</label>
                            <select name="numeros[{{ $item->id }}]" required>
                                <option value="">Selecciona...</option>
                                @php
                                    $tipo = strtolower($item->tipo);

                                    if (str_contains($tipo, 'iphone') || str_contains($tipo, 'tipo c')) {
                                        $tipo = 'cargador';
                                    }
                                    if (str_contains($tipo, 'v8')) {
                                        $tipo = 'v8';
                                    }
                                    if (str_contains($tipo, 'cable') && str_contains($tipo, 'red')) {
                                        $tipo = 'cableRed';
                                    }
                                    if (str_contains($tipo, 'control')) {
                                        $tipo = 'control';
                                    }
                                    if (str_contains($tipo, 'extension')) {
                                        $tipo = 'extension';
                                    }
                                    if (str_contains($tipo, 'audifono')) {
                                        $tipo = 'audifono';
                                    }
                                    if (str_contains($tipo, 'vga')) {
                                        $tipo = 'vga';
                                    }
                                    if (str_contains($tipo, 'convertidor')) {
                                        $tipo = 'convertidor';
                                    }
                                    if (str_contains($tipo, 'señalador')) {
                                        $tipo = 'señalador';
                                    }

                                    $limites = [
                                        'cañon' => 8,
                                        'hdmi' => 13,
                                        'cargador' => 8,
                                        'control' => 17,
                                        'cableRed' => 12,
                                        'extension' => 11,
                                        'v8' => 4,
                                        'audifono' => 4,
                                        'vga' => 13,
                                        'convertidor' => 1,
                                        'señalador' => 1,
                                    ];

                                    $limite = $limites[$tipo] ?? 8;
                                @endphp

                                @for($i = 1; $i <= $limite; $i++)
                                    @php
                                        $opcion = strtoupper($item->tipo) . '_' . $i;
                                        $yaAsignado = \App\Models\SInsumo::where('numero_asignado', $opcion)
                                            ->where('estatus', 'en tiempo')
                                            ->exists();
                                    @endphp
                                    @if(!$yaAsignado)
                                        <option value="{{ $opcion }}">{{ $opcion }}</option>
                                    @endif
                                @endfor
                            </select>
                        @endforeach

                        <button type="submit">Guardar</button>
                    </form>

                    {{-- Botón Eliminar --}}
                    <form method="POST" action="{{ route('admin.eliminarSolicitud', $solicitud->id) }}" onsubmit="return confirm('¿Estás seguro de eliminar esta solicitud?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="devolver">Eliminar</button>
                    </form>
                </div>
            @empty
                <p>No hay solicitudes pendientes.</p>
            @endforelse
        </div>

        {{-- SOLICITUDES ACTIVAS --}}
        <div class="card">
            <h3>Solicitudes Activas</h3>
            @forelse($solicitudesActivas as $solicitud)
                <div class="registro">
                    <p><strong>Nombre:</strong> {{ $solicitud->nombre }}</p>
                    <p><strong>No. Cuenta:</strong> {{ $solicitud->n_cuenta }}</p>
                    <p><strong>Fecha entrega:</strong> {{ \Carbon\Carbon::parse($solicitud->fecha_entrega)->format('d/m/Y') }}</p>

                    @foreach($solicitud->insumos as $item)
                        @php
                            $editarId = "editar-insumo-{$item->id}";
                            $formId = "form-editar-{$item->id}";

                            // Definir límite de números asignados
                            $tipo = strtolower($item->tipo);
                            if (str_contains($tipo, 'iphone') || str_contains($tipo, 'tipo c')) {
                                $tipo = 'cargador';
                            }
                            if (str_contains($tipo, 'v8')) {
                                $tipo = 'v8';
                            }
                            if (str_contains($tipo, 'cable') && str_contains($tipo, 'red')) {
                                $tipo = 'cableRed';
                            }
                            if (str_contains($tipo, 'control')) {
                                $tipo = 'control';
                            }
                            if (str_contains($tipo, 'extension')) {
                                $tipo = 'extension';
                            }
                            if (str_contains($tipo, 'audifono')) {
                                $tipo = 'audifono';
                            }
                            if (str_contains($tipo, 'vga')) {
                                $tipo = 'vga';
                            }
                            if (str_contains($tipo, 'convertidor')) {
                                $tipo = 'convertidor';
                            }
                            if (str_contains($tipo, 'señalador')) {
                                $tipo = 'señalador';
                            }

                            $limites = [
                                'cañon' => 8,
                                'hdmi' => 13,
                                'cargador' => 8,
                                'control' => 17,
                                'cableRed' => 12,
                                'extension' => 11,
                                'v8' => 4,
                                'audifono' => 4,
                                'vga' => 13,
                                'convertidor' => 1,
                                'señalador' => 1,
                            ];

                            $limite = $limites[$tipo] ?? 20; // Si no está en la lista, del 1 al 20
                        @endphp

                        <div id="{{ $editarId }}">
                            <strong>{{ ucfirst($item->tipo) }}:</strong>
                            <span class="texto-numero">
                                {{ $item->numero_asignado ?? 'Sin número' }}
                            </span>

                            <form id="{{ $formId }}" method="POST" action="{{ route('admin.actualizarNoInsumo', $item->id) }}" style="display:none;">
                                @csrf
                                @method('PUT')

                                <select name="no_insumo" required>
                                    <option value="">Selecciona...</option>
                                    @for($i = 1; $i <= $limite; $i++)
                                        @php
                                            $opcion = strtoupper($item->tipo) . '_' . $i;
                                            $yaAsignado = \App\Models\SInsumo::where('numero_asignado', $opcion)
                                                ->where('estatus', 'en tiempo')
                                                ->where('id', '!=', $item->id)
                                                ->exists();
                                        @endphp
                                        @if(!$yaAsignado)
                                            <option value="{{ $opcion }}" {{ ($item->numero_asignado === $opcion) ? 'selected' : '' }}>{{ $opcion }}</option>
                                        @endif
                                    @endfor
                                </select>

                                <button type="submit" class="guardar">Guardar</button>
                                <button type="button" class="cancelar" data-target="{{ $editarId }}">Cancelar</button>
                            </form>

                            <button type="button" class="editar" data-target="{{ $editarId }}" data-form="{{ $formId }}">Editar</button>
                        </div>
                    @endforeach

                    <p class="estado
                        @if($solicitud->estatus_calculado == 'devuelto') devuelto
                        @elseif($solicitud->estatus_calculado == 'con deuda') deuda
                        @else tiempo
                        @endif
                    ">
                        {{ ucfirst($solicitud->estatus_calculado) }}
                    </p>

                    @if($solicitud->estatus_calculado !== 'devuelto')
                        <form method="POST" action="{{ route('admin.devolver', $solicitud->id) }}">
                            @csrf
                            @method('PUT')
                            <button type="submit" class="devolver">Marcar como devuelto</button>
                        </form>
                    @endif
                </div>
            @empty
                <p>No hay solicitudes activas.</p>
            @endforelse
        </div>
    </div>

    <script>
        // Mostrar formulario editar y ocultar texto
        document.querySelectorAll('button.editar').forEach(btn => {
            btn.addEventListener('click', () => {
                const editarDiv = document.getElementById(btn.dataset.target);
                const form = document.getElementById(btn.dataset.form);

                editarDiv.querySelector('.texto-numero').style.display = 'none';
                form.style.display = 'inline-flex';

                btn.style.display = 'none';
            });
        });

        // Cancelar edición
        document.querySelectorAll('button.cancelar').forEach(btn => {
            btn.addEventListener('click', () => {
                const targetId = btn.dataset.target;
                const editarDiv = document.getElementById(targetId);
                const form = document.getElementById(btn.closest('form').id);
                const editarBtn = editarDiv.querySelector('button.editar');

                form.style.display = 'none';
                editarDiv.querySelector('.texto-numero').style.display = 'inline';
                editarBtn.style.display = 'inline-block';
            });
        });
    </script>

</body>
</html>
