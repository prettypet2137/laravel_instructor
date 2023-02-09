<?php

namespace Modules\Events\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Database\Eloquent\Factory;
use Modules\Events\Console\GuestEmailCommand;
use Modules\Events\Console\BirthdayGreeting;
use Modules\Events\Console\EventReminderDayBefore;
use Modules\Events\Console\EventReminderDayOf;
use Modules\Events\Console\FollowUpAfterCourse;

class EventsServiceProvider extends ServiceProvider
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
        $this->registerCommands();
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
    }

    /**
     * Register translations.
     *
     * @return void
     */
    public function registerTranslations()
    {
        $langPath = resource_path('lang/modules/events');

        if (is_dir($langPath)) {
            $this->loadTranslationsFrom($langPath, 'events');
        } else {
            $this->loadTranslationsFrom(__DIR__ . '/../Resources/lang', 'events');
        }
    }

    /**
     * Register config.
     *
     * @return void
     */
    protected function registerConfig()
    {
        $this->publishes([
            __DIR__ . '/../Config/config.php' => config_path('events.php'),
        ], 'config');
        $this->mergeConfigFrom(
            __DIR__ . '/../Config/config.php', 'events'
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
            GuestEmailCommand::class,
            BirthdayGreeting::class,
            EventReminderDayBefore::class,
            EventReminderDayOf::class,
            FollowUpAfterCourse::class
        ]);

    }

    /**
     * Register views.
     *
     * @return void
     */
    public function registerViews()
    {
        $viewPath = resource_path('views/modules/events');

        $sourcePath = __DIR__ . '/../Resources/views';

        $this->publishes([
            $sourcePath => $viewPath
        ], 'views');

        $this->loadViewsFrom(array_merge(array_map(function ($path) {
            return $path . '/modules/events';
        }, \Config::get('view.paths')), [$sourcePath]), 'events');
    }

    /**
     * Register an additional directory of factories.
     *
     * @return void
     */
    public function registerFactories()
    {
        if (!app()->environment('production')) {
            app(Factory::class)->load(__DIR__ . '/../Database/factories');
        }
    }
}
