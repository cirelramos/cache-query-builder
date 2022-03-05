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
        $path = $this->getConfigPath();
        $this->mergeConfigFrom($path, 'bar');
    }

    private function publishConfig()
    {
        $path = $this->getConfigPath();
        $this->publishes([$path => config_path('cache-query.php')], 'config');
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
