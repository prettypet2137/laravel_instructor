<?php

namespace Modules\PagesWebsite\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Illuminate\Support\Facades\View;
use Modules\PagesWebsite\Entities\PageWebsite;

class PagesWebsiteServiceProvider extends ServiceProvider
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
        $this->registerViewVariables();
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
            __DIR__.'/../Config/config.php' => config_path('pageswebsite.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__.'/../Config/config.php', 'pageswebsite'
        );
    }
    /**
     * Register views variables.
     *
     * @return void
     */
    protected function registerViewVariables()
    {
        $skin  = config('app.SITE_LANDING');

        View::composer(['themes::'.$skin.'.layout'], function ($view) {

            $pagewebsites = PageWebsite::active()->get();

            $view->with('pagewebsites', $pagewebsites);

        });
    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/pageswebsite');

        $sourcePath = __DIR__.'/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ],'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/pageswebsite';
        }, \Config::get('view.paths')), [$sourcePath]), 'pageswebsite');
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/pageswebsite');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'pageswebsite');
        } else {
            $this->loadTranslationsFrom(__DIR__ .'/../Resources/lang', 'pageswebsite');
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
