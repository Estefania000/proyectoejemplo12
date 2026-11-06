<?php

use App\Http\Controllers\PaginaController;
use Illuminate\Support\Facades\Route;

// Página de inicio
Route::get('/', [PaginaController::class, 'inicio'])->name('inicio');

// Vista de alumno
Route::get('/alumno', [PaginaController::class, 'alumno'])->name('alumno');

// Solicitud de préstamo
Route::get('/alumno/prestamo', [PaginaController::class, 'prestamo'])->name('alumno.prestamo');
Route::post('/alumno/prestamo/guardar', [PaginaController::class, 'guardarPrestamo'])->name('alumno.guardar');

// Devolución de insumos
Route::get('/alumno/devolucion', [PaginaController::class, 'devolucion'])->name('alumno.devolucion');
Route::post('/alumno/devolucion/verificar', [PaginaController::class, 'verificarDevolucion'])->name('alumno.verificar');
Route::post('/alumno/devolver', [PaginaController::class, 'devolver'])->name('alumno.devolver');

// Login y panel de administración
Route::get('/admin/login', [PaginaController::class, 'loginAdmin'])->name('admin.login');
Route::post('/admin/login', [PaginaController::class, 'procesarLogin'])->name('admin.login.post');
Route::post('/admin/logout', [PaginaController::class, 'cerrarSesion'])->name('admin.logout');

// Vista de administrador
Route::get('/admin', [PaginaController::class, 'administrador'])->name('admin');

// Crear y guardar usuarios
Route::get('/admin/usuario', [PaginaController::class, 'mostrarFormularioUsuario'])->name('admin.usuario');
Route::post('/admin/guardar-usuario', [PaginaController::class, 'guardarUsuario'])->name('admin.guardar_usuario');

// Excel
Route::get('/admin/excel', [PaginaController::class, 'descargarExcel'])->name('admin.descargarExcel');

// Papeleta individual
Route::get('/admin/insumos/{id}/papeleta', [PaginaController::class, 'mostrarPapeleta'])->name('admin.papeleta');

// Actualización de número de insumo
Route::put('/admin/insumos/{id}/no-insumo', [PaginaController::class, 'actualizarNoInsumo'])->name('admin.actualizarNoInsumo');

// Marcar como devuelto (desde admin)
Route::put('/admin/insumos/{id}/devolver', [PaginaController::class, 'devolver'])->name('admin.devolver');

// 🔧 NUEVAS RUTAS PARA ADMINISTRAR LOS S_INSUMOS:

// Vista para asignar número a insumos por solicitud
Route::get('/admin/solicitud/{id}/asignar-insumos', [PaginaController::class, 'asignarNumerosInsumos'])->name('admin.asignarInsumos');

// Guardar números asignados
Route::post('/admin/solicitud/{id}/guardar-insumos', [PaginaController::class, 'guardarNumerosInsumos'])->name('admin.guardarNumerosInsumos');

// Mostrar reporte en HTML
Route::get('/admin/reporte', [PaginaController::class, 'mostrarReporte'])->name('admin.reporte');

// Descargar Excel
Route::get('/admin/descargarExcel', [PaginaController::class, 'descargarExcel'])->name('admin.descargarExcel');
Route::get('/admin/reporte', [PaginaController::class, 'mostrarReporte'])->name('admin.mostrarReporte');
Route::get('/admin/reporte/descargar', [PaginaController::class, 'descargarExcel'])->name('admin.descargarExcel');

//solicitud pendiente eliminar
Route::delete('/admin/solicitud/{id}/eliminar', [PaginaController::class, 'eliminarSolicitud'])->name('admin.eliminarSolicitud');

//vista excel 
Route::get('/admin/excel', [PaginaController::class, 'vistaExcel'])->name('admin.excelVista');
