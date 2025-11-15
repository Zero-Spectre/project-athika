<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\InstrukturMiddleware;
use App\Http\Middleware\PesertaMiddleware;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Route::aliasMiddleware('admin', AdminMiddleware::class);
        Route::aliasMiddleware('instruktur', InstrukturMiddleware::class);
        Route::aliasMiddleware('peserta', PesertaMiddleware::class);
    }
}