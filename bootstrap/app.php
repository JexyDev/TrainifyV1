<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Register middleware aliases
        $middleware->alias([
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'trainer' => \App\Http\Middleware\TrainerMiddleware::class,
            'user' => \App\Http\Middleware\UserMiddleware::class,
        ]);
        
        // Customize redirect for authenticated users trying to access guest routes
        $middleware->redirectGuestsTo(function () {
            if (auth()->check()) {
                $user = auth()->user();
                if ($user->isAdmin()) {
                    return route('admin.dashboard');
                } elseif ($user->isTrainer()) {
                    return route('trainer.dashboard');
                } else {
                    return route('user.dashboard');
                }
            }
            return route('login');
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
