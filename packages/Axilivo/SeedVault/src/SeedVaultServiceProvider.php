<?php

namespace Axilivo\SeedVault;

use Illuminate\Support\ServiceProvider;

class SeedVaultServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/seedvault.php', 'seedvault');
    }

    public function boot()
    {
        $this->loadRoutesFrom(__DIR__ . '/../routes/web.php');
        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'seedvault');

        if ($this->app->runningInConsole()) {
            $this->commands([
                \Axilivo\SeedVault\Commands\CreateSnapshotCommand::class,
            ]);
        }

            $this->publishes([
                __DIR__ . '/../config/seedvault.php' => config_path('seedvault.php'),
            ], 'seedvault-config');
        
    }
}
