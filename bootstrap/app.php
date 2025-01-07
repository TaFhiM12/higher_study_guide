<?php
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(function (\Illuminate\Routing\Router $router) {
        $router->group(['middleware' => 'web'], function () {
            require __DIR__.'/../routes/web.php';
        });
    })
    ->withMiddleware(function (Middleware $middleware) {
        // Use array to register aliases for middleware
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Handle exceptions here
    })->create();
