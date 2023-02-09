<?php

namespace Modules\Events\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use Modules\User\Entities\User;

class CommentEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user, $data)
    {
        $this->user = $user;
        $this->data = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $user = $this->user;
        $data = $this->data;

        Mail::send([], [], function ($message) use ($user, $data) {
            $sender_address = $data['email'];
            $sender_name = $data['name'];
            $message
                ->from($address = $sender_address, $name = $sender_name)
                ->to($user->email)
                ->subject($data['subject'])
                ->setBody($data['body'], 'text/html');
        });
    }
}
