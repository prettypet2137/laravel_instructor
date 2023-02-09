<?php

namespace Modules\Saas\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Console\Scheduling\Schedule;

class ScheduleServiceProvider extends ServiceProvider
{
    /**
     * Register the service provider.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->booted(function () {
            $schedule = $this->app->make(Schedule::class);

            $schedule->command('rb:expired')
            ->everyMinute()
            ->name('expired')
            ->withoutOverlapping(5);


            $schedule->command('rb:billingcycle')
            ->everyMinute()
            ->name('billingcycle')
            ->withoutOverlapping(5);
            
        });


    }

    public function register()
    {
        //
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