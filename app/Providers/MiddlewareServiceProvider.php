<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Contracts\Http\Kernel;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\OperatorMiddleware;
use App\Http\Middleware\RoleMiddleware;

// use App\Http\Middleware\EditorMiddleware;
// use App\Http\Middleware\UserMiddleware;
// use App\Http\Middleware\RoleMiddleware;

class MiddlewareServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $router = $this->app['router'];
        
        // Register role middlewares
        $router->aliasMiddleware('role.admin', AdminMiddleware::class);
        $router->aliasMiddleware('role.operator', OperatorMiddleware::class);
        $router->aliasMiddleware('role', RoleMiddleware::class);
        // $router->aliasMiddleware('role.user', UserMiddleware::class);
        // $router->aliasMiddleware('roles', RoleMiddleware::class);
    }
}
