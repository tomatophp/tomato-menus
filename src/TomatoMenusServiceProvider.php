<?php

namespace TomatoPHP\TomatoMenus;

use Illuminate\Support\ServiceProvider;
use TomatoPHP\TomatoKetchup\Services\TomatoCore;
use TomatoPHP\TomatoMenus\Menus\MenusMenu;
use TomatoPHP\TomatoMenus\Services\MenuRenderBase;
use TomatoPHP\TomatoPHP\Services\Menu\TomatoMenuRegister;


class TomatoMenusServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //Register generate command
        $this->commands([
           \TomatoPHP\TomatoMenus\Console\TomatoMenusInstall::class,
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

        TomatoMenuRegister::registerMenu(MenusMenu::class);

    }

    public function boot(): void
    {
        //
    }
}
