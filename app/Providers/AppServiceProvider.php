<?php

namespace App\Providers;

use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void {}

    public function boot(): void
    {
        // Форсируем HTTPS для Railway (приложение за HTTPS-прокси)
        if (config('app.env') === 'production') {
            URL::forceScheme('https');
        }
    }
}
