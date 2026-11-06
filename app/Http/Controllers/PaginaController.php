<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Solicitud;
use App\Models\SInsumo;
use App\Models\Usuario;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;

class PaginaController extends Controller
{
    public function inicio() {
        return view('inicio');
    }

    public function alumno() {
        return view('alumno');
    }

    public function prestamo() {
        return view('prestamo');
    }

    public function guardarPrestamo(Request $request) {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'n_cuenta' => 'required|string|max:50',
            'aula' => 'required|string|max:50',
            'tel' => 'required|string|max:50',
            'unidad_aprendizaje' => 'required|string|max:255',
            'profesor' => 'required|string|max:255',
            'licenciatura' => 'required|string',
            'insumo' => 'required|array|min:1',
        ]);

        $solicitudFecha = Carbon::now('America/Mexico_City');

        $insumosSeleccionados = (array) $request->insumo;

        if (in_array('OTRO', $insumosSeleccionados) && $request->filled('insumo_otro')) {
            $insumosSeleccionados = array_diff($insumosSeleccionados, ['OTRO']);
            $insumosSeleccionados[] = $request->insumo_otro;
        }

        $solicitudModel = Solicitud::create([
            'nombre' => $request->nombre,
            'n_cuenta' => $request->n_cuenta,
            'aula' => $request->aula,
            'tel' => $request->tel,
            'unidad_aprendizaje' => $request->unidad_aprendizaje,
            'profesor' => $request->profesor,
            'licenciatura' => $request->licenciatura,
            'fecha_solicitud' => $solicitudFecha,
            'fecha_entrega' => null,
            'estatus' => 'en tiempo',
            'no_insumo' => null,
        ]);

        // Guardar insumos relacionados
        foreach ($insumosSeleccionados as $item) {
            SInsumo::create([
                'solicitud_id' => $solicitudModel->id,
                'tipo' => $item,
                'numero_asignado' => null,
                'estatus' => 'en tiempo',
            ]);
        }

        return redirect()->route('alumno')->with('success', 'Solicitud enviada.');
    }

    public function devolucion() {
        $solicitudes = Solicitud::whereHas('insumos', function ($query) {
            $query->where('estatus', '!=', 'devuelto');
        })->get();

        return view('devolucion', compact('solicitudes'));
    }

    public function actualizarNoInsumo(Request $request, $id) {
    $request->validate([
        'no_insumo' => 'nullable|string|max:20',
    ]);

    // Buscar insumo por id
    $insumo = SInsumo::findOrFail($id);
    $insumo->numero_asignado = $request->no_insumo;
    $insumo->save();

    return redirect()->route('admin')->with('success', 'Número de insumo actualizado correctamente.');
}


    public function devolver($id) {
        $solicitud = Solicitud::findOrFail($id);

        foreach ($solicitud->insumos as $insumo) {
            $insumo->estatus = 'devuelto';
            $insumo->save();
        }

        return redirect()->route('admin')->with('success', 'Insumo marcado como devuelto.');
    }

    public function loginAdmin() {
        return view('admin_login');
    }

    public function procesarLogin(Request $request) {
        $request->validate([
            'nombre' => 'required',
            'contrasena' => 'required',
        ]);

        $usuario = Usuario::whereRaw("LOWER(CONCAT(nombre, ' ', app, ' ', apm)) = ?", [strtolower($request->nombre)])
            ->where('contrasena', $request->contrasena)
            ->first();

        if ($usuario) {
            Session::put('usuario_nombre', strtolower($usuario->nombre . ' ' . $usuario->app . ' ' . $usuario->apm));
            return redirect()->route('admin');
        } else {
            return back()->with('error', 'Credenciales incorrectas.');
        }
    }

    public function administrador(Request $request) {
        if (!Session::has('usuario_nombre')) {
            return redirect()->route('admin.login')->with('error', 'Inicia sesión primero.');
        }

        $usuarioNombre = Session::get('usuario_nombre');
        $usuarioLogueado = Usuario::whereRaw("LOWER(CONCAT(nombre, ' ', app, ' ', apm)) = ?", [$usuarioNombre])->first();

        // Solicitudes pendientes (sin fecha_entrega y sin numero asignado en insumos)
        $solicitudesPendientes = Solicitud::with('insumos')
            ->whereNull('fecha_entrega')
            ->whereHas('insumos', function ($query) {
                $query->whereNull('numero_asignado');
            })
            ->orderBy('updated_at', 'desc')
            ->get();

        // Solicitudes activas (con fecha_entrega y insumos no devueltos)
        $solicitudesActivas = Solicitud::with('insumos')
            ->whereNotNull('fecha_entrega')
            ->whereHas('insumos', function ($query) {
                $query->where('estatus', '!=', 'devuelto');
            })
            ->orderBy('updated_at', 'desc')
            ->get();

        // Calcular estatus dinámico por fecha
        foreach ($solicitudesActivas as $solicitud) {
            $todosDevueltos = $solicitud->insumos->every(fn($insumo) => $insumo->estatus === 'devuelto');

            if ($todosDevueltos) {
                $solicitud->estatus_calculado = 'devuelto';
            } else {
                $fechaEntrega = Carbon::parse($solicitud->fecha_entrega)->startOfDay();
                $hoy = Carbon::now()->startOfDay();

                if ($fechaEntrega->lt($hoy)) {
                    $solicitud->estatus_calculado = 'con deuda';
                } else {
                    $solicitud->estatus_calculado = 'en tiempo';
                }
            }
        }

        $puedeAgregar = $usuarioNombre === 'jorge higinio enriquez miraflor';

        return view('admin', compact(
            'solicitudesPendientes',
            'solicitudesActivas',
            'puedeAgregar',
            'usuarioLogueado'
        ));
    }

    public function asignarNumerosInsumos($id) {
        $solicitud = Solicitud::with('insumos')->findOrFail($id);
        return view('admin_asignar_insumos', compact('solicitud'));
    }

    public function guardarNumerosInsumos(Request $request, $id) {
        $solicitud = Solicitud::with('insumos')->findOrFail($id);

        $request->validate([
            'fecha_entrega' => 'required|date',
            'numeros' => 'required|array',
            'numeros.*' => 'required|string',
        ]);

        $solicitud->fecha_entrega = $request->fecha_entrega;
        $solicitud->save();

        foreach ($solicitud->insumos as $insumo) {
            if (isset($request->numeros[$insumo->id])) {
                $insumo->numero_asignado = $request->numeros[$insumo->id];
                $insumo->estatus = 'en tiempo';
                $insumo->save();
            }
        }

        return redirect()->route('admin')->with('success', 'Números asignados y fecha guardada.');
    }

    public function mostrarFormularioUsuario()
{
    // Validar que el usuario tenga permiso
    if (session('usuario_nombre') !== 'jorge higinio enriquez miraflor') {
        return redirect()->route('admin')->with('error', 'No tienes permiso para agregar usuarios.');
    }

    // Retornar la vista 'usuario' (resources/views/usuario.blade.php)
    return view('usuario');
}

public function guardarUsuario(Request $request)
{
    // Validar datos del formulario
    $validated = $request->validate([
        'nombre' => 'required|string|max:255',
        'app' => 'required|string|max:255',
        'apm' => 'required|string|max:255',
        'escuela' => 'required|string|max:255',
        'contrasena' => 'required|string|min:6',
    ]);

    // Crear nuevo usuario
    $usuario = new Usuario();
    $usuario->nombre = $validated['nombre'];
    $usuario->app = $validated['app'];
    $usuario->apm = $validated['apm'];
    $usuario->escuela = $validated['escuela'];
    $usuario->contrasena = bcrypt($validated['contrasena']); // Encriptar contraseña
    $usuario->save();

    // Redirigir a la misma vista con mensaje de éxito
    return redirect()->route('admin.usuario')->with('success', 'Usuario creado correctamente.');
}

    public function cerrarSesion() {
        Session::forget('usuario_nombre');
        return redirect()->route('admin.login')->with('success', 'Sesión cerrada correctamente.');
    }

    public function mostrarPapeleta($id) {
        $solicitud = Solicitud::findOrFail($id);

        $todosDevueltos = $solicitud->insumos->every(fn($insumo) => $insumo->estatus === 'devuelto');
        if ($todosDevueltos) {
            return redirect()->route('admin')->with('error', 'No se puede generar papeleta para insumo devuelto.');
        }

        return view('papeleta', compact('solicitud'));
    }


    // NUEVO: Mostrar formulario para seleccionar año y semestre para reporte Excel
    public function mostrarReporte(Request $request) {
        $anio = $request->input('anio', date('Y'));
        $semestre = strtoupper($request->input('semestre', 'A'));

        return view('admin_reporte', compact('anio', 'semestre'));
    }

    // NUEVO: Descargar reporte Excel filtrado por año y semestre
   public function descargarExcel(Request $request) {
    $anio = $request->input('anio', date('Y'));
    $semestre = strtoupper($request->input('semestre', 'A'));

    if ($semestre === 'A') {
        $fechaInicio = "$anio-02-01 00:00:00";
        $fechaFin = "$anio-07-31 23:59:59";
    } else {
        $anioFin = $anio + 1;
        $fechaInicio = "$anio-08-01 00:00:00";
        $fechaFin = "$anioFin-01-31 23:59:59";
    }

    $solicitudes = Solicitud::whereBetween('updated_at', [$fechaInicio, $fechaFin])
        ->orderBy('updated_at', 'desc')
        ->get();

    $headers = [
        "Content-Type" => "application/vnd.ms-excel",
        "Content-Disposition" => "attachment; filename=solicitudes_{$anio}{$semestre}.xls",
    ];

    // Encabezado sin estatus ni número de insumo
    $contenido = "Nombre\tCuenta\tInsumo\tFecha Solicitud\tFecha Entrega\n";

    foreach ($solicitudes as $s) {
        $insumosStr = $s->insumos->map(fn($i) => $i->tipo . '(' . ($i->numero_asignado ?? '-') . ')')->implode(', ');

        $contenido .= "{$s->nombre}\t{$s->n_cuenta}\t{$insumosStr}\t" .
            Carbon::parse($s->fecha_solicitud)->format('d/m/Y H:i') . "\t" .
            ($s->fecha_entrega ? Carbon::parse($s->fecha_entrega)->format('d/m/Y H:i') : '-') . "\n";
    }

    return response($contenido, 200, $headers);
}



   public function eliminarSolicitud($id)
{
    $solicitud = Solicitud::findOrFail($id);

    // Eliminar insumos relacionados
    $solicitud->insumos()->delete();

    // Eliminar la solicitud
    $solicitud->delete();

    return redirect()->route('admin')->with('success', 'Solicitud eliminada correctamente.');
}


    public function vistaExcel()
{
    return view('excel'); // Asegúrate de tener esta vista creada
}



}
