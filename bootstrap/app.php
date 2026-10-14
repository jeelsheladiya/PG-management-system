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
        $middleware->alias([
            'adminauth' => \App\Http\Middleware\AdminAuth::class,
            'adminguest' => \App\Http\Middleware\AdminGuest::class,
            'staff.auth' => \App\Http\Middleware\StaffAuth::class,
            'staff.guest' => \App\Http\Middleware\StaffGuest::class,
            'member.auth' => \App\Http\Middleware\MemberAuth::class,
            'member.guest' => \App\Http\Middleware\MemberGuest::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();
