<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))

    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // keep defaults; customize if needed later
        // You can register additional middleware if needed.
        // TrustProxies remains via App\Http\Middleware\TrustProxies.
        // CORS is handled by \Illuminate\Http\Middleware\HandleCors.
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // customize exception handling if needed
    })
    ->create();
