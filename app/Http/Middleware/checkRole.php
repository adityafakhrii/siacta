<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class checkRole
{
    public function handle($request, Closure $next,...$roles)
    {
        if (in_array($request->user()->role,$roles)) {
            return $next($request);
        }else{
            return redirect('/');
        }
    }
}
