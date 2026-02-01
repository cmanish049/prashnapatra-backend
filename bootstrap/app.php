<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\ThrottleRequestsException;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\TooManyRequestsHttpException;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->alias([
            'api.key' => \App\Http\Middleware\ValidateApiKey::class,
            'gzip' => \App\Http\Middleware\GzipResponse::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->render(function (ThrottleRequestsException|TooManyRequestsHttpException $e, $request) {
            if ($request->is('api/*')) {
                return response()->json([
                    'status' => 'error',
                    'error' => true,
                    'message' => 'Too many requests. Please try again later.',
                ], Response::HTTP_TOO_MANY_REQUESTS, $e->getHeaders());
            }
        });
    })->create();
