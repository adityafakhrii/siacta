<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class checkRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!auth()->guard()->check()) {
            return redirect('/login');
        }

        $userRole = auth()->guard()->user()->role; // Sesuaikan dengan nama kolom role di database

        if (!in_array($userRole, $roles)) {
            abort(403, 'Unauthorized');
        }

        return $next($request);
    }
}
