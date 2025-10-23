<?php

namespace App\Http\Middleware;

use Closure;

class PrevenirMiddleware
{
    public function handle($request, Closure $next)
    {
        $Respuesta = $next($request);
        return $Respuesta->header('Cache-Control','no-cache, no-store, max-age=0, must-revalidate')
                        ->header('Pragma','no-cache')
                        ->header('Expires','Sat, 01 Jan 1990 GMT');
    }
}
