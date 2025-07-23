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
    ->withMiddleware(function (Middleware $middleware): void {
        //
    })
    ->withExceptions(function (Exceptions $exceptions) {

    // 捕捉 Symfony 的 AccessDeniedHttpException
    $exceptions->render(function (\Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException $e) {
        return response()->view('errors.403_custom', [], 403);
    });

    // 也捕捉 Laravel 的 AuthorizationException (作為保險)
    $exceptions->render(function (\Illuminate\Auth\Access\AuthorizationException $e) {
        return response()->view('errors.403_custom', [], 403);
    });

})->create();