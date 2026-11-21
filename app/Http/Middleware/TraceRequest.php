<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class TraceRequest
{
    /**
     * Maneja una solicitud entrante.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Guardamos el tiempo de inicio
        $start = microtime(true);
        
        // Continuamos con la petición
        $response = $next($request);
        
        // Calculamos la duración en milisegundos
        $duration = round((microtime(true) - $start) * 1000, 2);

        // Registramos la traza en el archivo de logs de Laravel
        Log::info('TRACE_REQUEST', [
            'method'      => $request->method(),
            'path'        => $request->path(),
            'status'      => $response->getStatusCode(),
            'duration_ms' => $duration,
            'ip'          => $request->ip(),
            'user_agent'  => $request->userAgent(),
        ]);

        return $response;
    }
}