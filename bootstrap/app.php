<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Session\TokenMismatchException;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        api: __DIR__.'/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Alias Middleware
        $middleware->alias([
            'is_admin' => \App\Http\Middleware\IsAdmin::class,
        ]);

        // Kecualikan logout, webhook Midtrans, dan AI Chat dari CSRF
        $middleware->validateCsrfTokens(except: [
            'logout',
            'ai-chat',
            'api/ai-chat',
            'midtrans/notification',
            'api/midtrans/notification',
            'midtrans/webhook',
            'midtrans/callback',
            'api/midtrans/webhook',
            'api/midtrans/callback',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        // Tangani jika sesi kadaluarsa (419 Token Mismatch) dengan redirect aman ke login
        $exceptions->render(function (TokenMismatchException $e, Request $request) {
            return redirect()->route('login')->with('status', 'Sesi Anda telah berakhir. Silakan login kembali.');
        });
    })->create();
