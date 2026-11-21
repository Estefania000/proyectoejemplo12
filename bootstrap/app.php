<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            // Ruta para exponer el log de disponibilidad generado por monitoreo.sh
            Route::get('/monitoreo-log', function () {
                $path = storage_path('logs/monitoreo_disponibilidad.log');
                if (!file_exists($path)) {
                    return response('Sin registros aún. Ejecuta ./monitoreo.sh', 200)
                        ->header('Content-Type', 'text/plain');
                }
                return response(file_get_contents($path), 200)
                    ->header('Content-Type', 'text/plain');
            })->withoutMiddleware([\App\Http\Middleware\TraceRequest::class]);
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Registramos el middleware de trazas globalmente
        $middleware->append(\App\Http\Middleware\TraceRequest::class);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();

    