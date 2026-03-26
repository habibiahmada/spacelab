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
        //
        $middleware->alias([
            'role' => \App\Http\Middleware\RoleMiddleware::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })
    ->withSchedule(function ($schedule) {
        $schedule->command('app:mark-alpha-attendance')
            ->everyMinute()
            ->withoutOverlapping();
        
        // CCTV Health Check - every minute
        $schedule->command('cctv:health-check')
            ->everyMinute()
            ->withoutOverlapping();
        
        // CCTV Retention Cleanup - every hour
        $schedule->command('cctv:retention-cleanup')
            ->hourly()
            ->withoutOverlapping();

        // CCTV Segment Metadata Sync - every 5 minutes
        $schedule->command('cctv:segment-index-sync')
            ->everyFiveMinutes()
            ->withoutOverlapping();
    })
    ->create();
