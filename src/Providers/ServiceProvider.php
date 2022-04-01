<?php

namespace Cirelramos\Cache\Providers;

/**
 *
 */
class ServiceProvider extends \Illuminate\Support\ServiceProvider
{
    public function register()
    {
        $this->mergeConfig();
    }

    public function boot()
    {
        $this->publishConfig();
        $this->publishMigrations();
    }

    private function mergeConfig()
    {
        $configPath = __DIR__.'/../config/cache-query.php';
        $this->mergeConfigFrom($configPath, 'l5-swagger');
    }

    private function publishConfig()
    {
        // Publish a config file
        $configPath = __DIR__.'/../config/cache-query.php';
        $this->publishes([
                             $configPath => config_path('cache-query.php'),
                         ], 'config');
    }

    private function publishMigrations()
    {
//        $path = $this->getMigrationsPath();
//        $this->publishes([$path => database_path('migrations')], 'migrations');
    }

    /**
     * @return string
     */
    private function getConfigPath()
    {
        return __DIR__ . '/../../config/cache-query.php';
    }

    /**
     * @return string
     */
    private function getMigrationsPath()
    {
        return __DIR__ . '/../database/migrations/';
    }
}
