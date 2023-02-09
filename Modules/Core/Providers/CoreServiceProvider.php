<?php

namespace Modules\Core\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\View;
use JoeDixon\Translation\Drivers\Translation;
use Illuminate\Support\Facades\App;
use Session;

class CoreServiceProvider extends ServiceProvider
{

    /**
     * Boot the application events.
     *
     * @return void
     */
    public function boot(Translation $translation)
    {
        $this->translation = $translation;
        $this->registerTranslations();
        $this->registerViewVariables();
        $this->registerConfig();
        $this->registerViews();
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
        $this->app->register(MailConfigServiceProvider::class);
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__.'/../Config/config.php' => config_path('core.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'core'
        );
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/core');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/core';
        }, \Config::get('view.paths')), [$sourcePath]), 'core');
    }

    protected function registerViewVariables()
    {
        View::composer(['core::partials.header-top'], function ($view) {

            $languages = $this->translation->allLanguages();
            $current_locale  = App::getLocale();
            $default_language = config('app.fallback_locale');
            
            $active_language = $languages->has($current_locale) ? $current_locale : $default_language;
            $view->with('languages', $languages);
            $view->with('active_language', $active_language);

        });
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/core');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'core');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'core');
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
