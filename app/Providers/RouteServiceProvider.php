<?php

declare(strict_types=1);

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

/**
 * Route service provider
 */
class RouteServiceProvider extends ServiceProvider
{
    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot(): void
    {
        $this->routes(
            static function () {
                Route::middleware('web')
                    ->group(base_path('routes/web.php'));

                Route::middleware('images')
                    ->group(base_path('routes/images.php'));
            }
        );
    }
}
