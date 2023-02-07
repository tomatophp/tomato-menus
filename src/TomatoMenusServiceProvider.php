<?php

namespace Tomatophp\TomatoMenus;

use Illuminate\Support\ServiceProvider;


class TomatoMenusServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //Register generate command
        $this->commands([
           \Tomatophp\TomatoMenus\Console\TomatoMenusInstall::class,
        ]);
 
        //Register Config file
        $this->mergeConfigFrom(__DIR__.'/../config/tomato-menus.php', 'tomato-menus');
 
        //Publish Config
        $this->publishes([
           __DIR__.'/../config/tomato-menus.php' => config_path('tomato-menus.php'),
        ], 'tomato-menus-config');
 
        //Register Migrations
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
 
        //Publish Migrations
        $this->publishes([
           __DIR__.'/../database/migrations' => database_path('migrations'),
        ], 'tomato-menus-migrations');
        //Register views
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'tomato-menus');
 
        //Publish Views
        $this->publishes([
           __DIR__.'/../resources/views' => resource_path('views/vendor/tomato-menus'),
        ], 'tomato-menus-views');
 
        //Register Langs
        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'tomato-menus');
 
        //Publish Lang
        $this->publishes([
           __DIR__.'/../resources/lang' => app_path('lang/vendor/tomato-menus'),
        ], 'tomato-menus-lang');
 
        //Register Routes
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
 
    }

    public function boot(): void
    {
        //you boot methods here
    }
}
