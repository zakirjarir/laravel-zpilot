<?php

namespace ZakirJarir\LaravelZPilot;

use Illuminate\Support\ServiceProvider;

class ZPilotServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/zpilot.php', 'zpilot'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(\Illuminate\Routing\Router $router)
    {
        // If not installed, force session driver to 'file' to prevent DB errors on startup
        if (!file_exists(storage_path('installed'))) {
            config(['session.driver' => 'file']);
        }

        // Automatically redirect to ZPilot if not installed
        $router->pushMiddlewareToGroup('web', \ZakirJarir\LaravelZPilot\Http\Middleware\RedirectIfNotInstalled::class);

        // Ensure .env exists to prevent application crash
        $envManager = new \ZakirJarir\LaravelZPilot\Helpers\EnvironmentManager();
        $envManager->ensureEnvExists();

        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/views', 'zpilot');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->publishes([
            __DIR__ . '/../config/zpilot.php' => config_path('zpilot.php'),
        ], 'zpilot-config');

        $this->publishes([
            __DIR__ . '/views' => resource_path('views/vendor/zpilot'),
        ], 'zpilot-views');
    }
}
