<?php

namespace App\Providers;

use App\Services\HtmlSanitizer;
use Illuminate\Support\ServiceProvider;

class HtmlPurifierServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        // Una sola instancia por request (construir HTMLPurifier no es barato).
        $this->app->singleton(HtmlSanitizer::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
