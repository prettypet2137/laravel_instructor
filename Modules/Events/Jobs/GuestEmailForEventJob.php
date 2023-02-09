<?php

namespace Modules\Events\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use Modules\Events\Entities\Event;
use Modules\Events\Entities\Guest;

class GuestEmailForEventJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $event;
    protected $guest;
    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Event $event, Guest $guest, $data)
    {
        $this->event = $event;
        $this->guest = $guest;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $event = $this->event;
        $guest = $this->guest;
        $subject = $this->data['subject'];
        $body = $this->data['body'];

        Mail::send([], [], function ($message) use ($event, $guest, $subject, $body) {
            $sender_address = config('mail.from.address');
            $sender_name = config('mail.from.name');

            if ($event->email_sender_email) {
                $sender_address = $event->email_sender_email;
            }
            if ($event->email_sender_name) {
                $sender_name = $event->email_sender_name;
            }

            $message
                ->from($address = $sender_address, $name = $sender_name)
                ->to($guest->email)
                ->subject($subject)
                ->setBody($body, 'text/html');

        });
    }
}
