<?php

namespace Modules\Events\Console;

use Illuminate\Console\Command;
use Modules\Events\Entities\Event;
use Modules\Events\Entities\Guest;
use Modules\Events\Jobs\GuestGreetingJob;
use Twilio\Rest\Client;

class GuestEmailCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'events:guests-emails';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for email reminder to be sent out day before and on the day listed event.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $now = date('Y-m-d H:i:s');
        $dayBefore = date('Y-m-d', strtotime('-1 day')) . ' 00:00:00';
        Event::with('guests')->whereDate('start_date', '>=', $dayBefore)->orWhereDate('start_date', '<=', $now)->chunk(100, function ($events) {
            foreach ($events as $event) {
                if (count($event->guests) > 0) {
                    foreach ($event->guests as $key => $guest) {
                        GuestGreetingJob::dispatch($event, $guest)->onQueue('guests_emails');
                    }
                }
            }
        });
    }
}
