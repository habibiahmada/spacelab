<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        // Tidak perlu custom Password Broker.
        // Laravel otomatis menggunakan model User
        // dan method sendPasswordResetNotification($token)
        // yang sudah kamu definisikan di model User.
    }
}
