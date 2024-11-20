<?php

namespace App\Providers;

use App\Models\DisplayOk;
use App\Observers\DisplayOkObserver;
use App\Services\DailyLoggerService;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(DailyLoggerService::class, function ($app) {
            return new DailyLoggerService();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //observer
        DisplayOk::observe(DisplayOkObserver::class);

        // Menggunakan Bootstrap untuk styling pagination
        Paginator::useBootstrap();
    }
}
