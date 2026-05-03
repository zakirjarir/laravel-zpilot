<?php

namespace ZakirJarir\LaravelInstaller;

use Illuminate\Support\ServiceProvider;

class InstallerServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../config/installer.php', 'installer'
        );
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot(\Illuminate\Routing\Router $router)
    {
        // Automatically redirect to installer if not installed
        $router->pushMiddlewareToGroup('web', \ZakirJarir\LaravelInstaller\Http\Middleware\RedirectIfNotInstalled::class);

        // Ensure .env exists to prevent application crash
        $envManager = new \ZakirJarir\LaravelInstaller\Helpers\EnvironmentManager();
        $envManager->ensureEnvExists();

        // Force session driver to 'file' for installer routes to prevent DB errors
        if (request()->is('install') || request()->is('install/*')) {
            config(['session.driver' => 'file']);
        }

        $this->loadRoutesFrom(__DIR__ . '/routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/views', 'installer');
        $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');

        $this->publishes([
            __DIR__ . '/../config/installer.php' => config_path('installer.php'),
        ], 'installer-config');

        $this->publishes([
            __DIR__ . '/views' => resource_path('views/vendor/installer'),
        ], 'installer-views');
    }
}
