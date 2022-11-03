<?php

namespace Hyvor\Laradocs;

use Hyvor\Laradocs\Console\CacheDocs;
use Illuminate\Support\ServiceProvider;

class LaradocsServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'laradocs_config');
    }

    public function boot() : void
    {
        //Route registration
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        //Views registration
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'laradocs_views');

        if ($this->app->runningInConsole()) {
            // Publish views for user customization
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/hyvor/laradocs'),
            ], 'views');

            // Publish config for user customization
            $this->publishes([
              __DIR__.'/../config/config.php' => config_path('laradocs_config.php'),
            ], 'config');

            // Publish assets for user customization
            $this->publishes([
                __DIR__.'/../resources/assets' => public_path('laradocs_assets'),
            ], 'assets');

            $this->commands([
                CacheDocs::class,
            ]);
        }
    }
}
