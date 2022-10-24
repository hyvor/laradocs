<?php

namespace Hyvor\Laradocs;

use Illuminate\Support\ServiceProvider;

class LaradocsServiceProvider extends ServiceProvider
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
            // Publish views for user customization
            $this->publishes([
                __DIR__.'/../resources/views' => resource_path('views/vendor/blogpackage'),
            ], 'views');

            // Publish config for user customization
            $this->publishes([
              __DIR__.'/../config/config.php' => config_path('docgenpackage.php'),
            ], 'config');

            // Publish assets for user customization
            $this->publishes([
                __DIR__.'/../resources/assets' => public_path('docgenassets'),
            ], 'assets');
        }
    }
}
