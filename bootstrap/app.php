<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')->group(base_path('routes/debug.php'));
        }
    )
    ->withMiddleware(function (Middleware $middleware): void {
        // TEMPORARILY DISABLED FOR DEBUGGING
        // $middleware->append(\App\Http\Middleware\SecurityHeaders::class);
        // if (app()->environment('production')) {
        //     $middleware->append(\App\Http\Middleware\ForceHttps::class);
        // }
        
        $middleware->throttleApi();
        
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
