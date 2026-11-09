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
        // Nama pendek untuk pengaman halaman
        $middleware->alias([
            'hanya_admin' => \App\Http\Middleware\HanyaAdmin::class,
            'hanya_pelanggan' => \App\Http\Middleware\HanyaPelanggan::class,
        ]);

        // Jika belum login, arahkan ke halaman masuk
        $middleware->redirectGuestsTo(fn () => route('masuk'));
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();