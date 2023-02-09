<?php

namespace Modules\User\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Mail;
use Modules\User\Entities\User;

class GuestEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $user;
    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(User $user,$data)
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

        Mail::send([], [] , function ($message) use ($user, $data){
            $body = config('user.USER_EMAIL_CONTENT');
            $body = str_replace('%name%', $user->name, $body);
            $body = str_replace('%body%', 'Email from instructorsdash.com', $body);

            $message
            ->to($user->email)
            ->subject($data['subject'])
            ->setBody($body, 'text/html');

        });
    }
}
