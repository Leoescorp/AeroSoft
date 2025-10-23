<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RolMiddleware
{
    public function handle($request, Closure $next, ...$IDROL) {
        if (!Auth::check()) {
            return redirect('/');
        }
        $User = Auth::user();
        if (in_array($User->id_rol, $IDROL)) {
            return $next($request);
        }
        return redirect('/');
    }
}
