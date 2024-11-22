<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        // web: __DIR__.'/../routes/web.php',
        commands: __DIR__ . '/../routes/console.php',
        health: '/up',
        using: function () {
            foreach (config('tenancy.central_domains') as $domain) {
                Route::middleware('web')->domain($domain)->group(base_path('routes/web.php'));

                Route::middleware('web')->domain('admin.' . $domain)->group(base_path('routes/admin.php'));
            }

            Route::middleware('web')->group(base_path('routes/tenant.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->statefulApi();
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
