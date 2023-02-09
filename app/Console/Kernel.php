<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;


class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // run mail or default queue.
        $schedule->command('queue:work --queue=guests_emails,users_emails,comments_emails,mail,default')
            ->name('queue')
            ->withoutOverlapping(20);

        //Command for email reminder to be sent out day before and on the day listed event.
        $schedule->command('events:guest-birthday-greetings')->daily();
        $schedule->command('events:event-reminder-day-before')->daily();
        $schedule->command('events:event-reminder-day-of')->daily();
        $schedule->command('events:follow-up-after-course')->daily();

        // $schedule->command('queue:retry all')
        //     ->hourly()
        //     ->withoutOverlapping(5);

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__ . '/Commands');

        require base_path('routes/console.php');
    }

    /**
     * Get the timezone that should be used by default for scheduled events.
     *
     * @return \DateTimeZone|string|null
     */
    protected function scheduleTimezone()
    {
        return config('app.timezone');
    }
}
