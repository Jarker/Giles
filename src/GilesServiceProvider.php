<?php
namespace Jarker\Giles;

use Illuminate\Support\ServiceProvider;

class GilesServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app['router']->namespace('Jarker\\Giles\\Controllers')
            ->middleware(['api'])
            ->group(function() {
                $this->loadRoutesFrom(__DIR__ . '/../routes/api.php');
            });
        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/giles.php', 'giles');
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['giles'];
    }
    
    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/giles.php' => config_path('giles.php'),
        ], 'giles.config');
    }
}
