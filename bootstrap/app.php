<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Exceptions\PostTooLargeException;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {
        $middleware->web(append:[
            \App\Http\Middleware\setLocale::class
        ]); 
    })
    ->withExceptions(function (Exceptions $exceptions): void {
        // error instead of directing to 413
        $exceptions->render(function (PostTooLargeException $e, Request $request) {
            return back()
                ->withInput()
                ->withErrors(['banner' => 'The upload is too large. Please choose a smaller image.']);
        });
    })->create();
