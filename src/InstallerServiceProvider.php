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
        // If not installed, force session driver to 'file' to prevent DB errors on startup
        if (!file_exists(storage_path('installed'))) {
            config(['session.driver' => 'file']);
        }

        // Automatically redirect to installer if not installed
        $router->pushMiddlewareToGroup('web', \ZakirJarir\LaravelInstaller\Http\Middleware\RedirectIfNotInstalled::class);

        // Ensure .env exists to prevent application crash
        $envManager = new \ZakirJarir\LaravelInstaller\Helpers\EnvironmentManager();
        $envManager->ensureEnvExists();

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
