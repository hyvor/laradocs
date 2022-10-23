<?php

namespace Hyvor\DocGenerator;

use Illuminate\Support\ServiceProvider;

class DocGeneratorServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/config.php', 'docgenpackage');
    }

    public function boot()
    {
        //Route registration
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        //Views registration
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'docgenviews');

        if ($this->app->runningInConsole()) {
            $this->publishes([
              __DIR__.'/../config/config.php' => config_path('docgenpackage.php'),
            ], 'config');

            // Publish assets
            $this->publishes([
                __DIR__.'/../resources/assets' => public_path('docgenassets'),
            ], 'assets');
        }
    }
}
