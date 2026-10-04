<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

$app = Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__ . '/../routes/web.php',
        api: __DIR__ . '/../routes/api.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append: [
            \App\Http\Middleware\Localization::class,
        ]);

        $middleware->alias([
            'role'         => \App\Http\Middleware\Role::class,
            'in-chat'      => \App\Http\Middleware\InChat::class,
            'has-passport' => \App\Http\Middleware\HasPassport::class,
            'has-office'   => \App\Http\Middleware\HasOffice::class,
            'has-company'  => \App\Http\Middleware\HasCompany::class,
            'identified'   => \App\Http\Middleware\Identified::class,
            'owner'        => \App\Http\Middleware\EnsureOwner::class,
            'old-slug'     => \App\Http\Middleware\RedirectOldAsicSlug::class,
        ]);

        $middleware->priority([
            \Illuminate\Foundation\Http\Middleware\HandlePrecognitiveRequests::class,
            \Illuminate\Cookie\Middleware\EncryptCookies::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \Illuminate\Contracts\Auth\Middleware\AuthenticatesRequests::class,
            \Illuminate\Routing\Middleware\ThrottleRequests::class,
            \Illuminate\Routing\Middleware\ThrottleRequestsWithRedis::class,
            \Illuminate\Contracts\Session\Middleware\AuthenticatesSessions::class,
            \App\Http\Middleware\RedirectOldAsicSlug::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
            \Illuminate\Auth\Middleware\Authorize::class,
        ]);

        $middleware->preventRequestForgery(except: [
            'order/webhook',
            'order/invoice/webhook',
            'amocrm/webhook/*',
        ]);
    })
    ->registered(function ($app) {
        if (!$app->environment('local')) $app->usePublicPath($app->basePath('public_html'));
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        $exceptions->shouldRenderJsonWhen(
            fn(Request $request) => $request->is('api/*') || $request->expectsJson(),
        );
    })->create();


return $app;
