<?php

namespace Modules\Settings\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use JoeDixon\Translation\Console\Commands\SynchroniseMissingTranslationKeys;
use JoeDixon\Translation\Console\Commands\SynchroniseTranslationsCommand;


class SettingsServiceProvider extends ServiceProvider
{
    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerTranslations();
        $this->registerConfig();
        $this->registerViews();
        $this->registerCommands();
        $this->registerFactories();
        $this->loadMigrationsFrom(__DIR__ . '/../Database/Migrations');
    }

    /**
     * Register the service provider.
     *
     * @return void
     */
    public function register()
    {
        $this->app->register(RouteServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('settings.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'settings'
        );
    }

    
    /**
     * Register command.
     *
     * @return void
     */
    protected function registerCommands()
    {
        $this->commands([
            SynchroniseMissingTranslationKeys::class,
            SynchroniseTranslationsCommand::class,
        ]);

    }


    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/settings');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/settings';
        }, \Config::get('view.paths')), [$sourcePath]), 'settings');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/settings');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'settings');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'settings');
        }
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (! app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/../Database/factories');
        }
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return [];
    }
}
