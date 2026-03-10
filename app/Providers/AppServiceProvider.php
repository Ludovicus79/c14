<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Registrar remember() como macro en Eloquent Builder
        // para garantizar compatibilidad con watson/rememberable en Laravel 6
        Builder::macro('remember', function ($seconds, $key = null) {
            $this->getQuery()->remember($seconds, $key);
            return $this;
        });

        Builder::macro('rememberForever', function ($key = null) {
            $this->getQuery()->rememberForever($key);
            return $this;
        });
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
