<?php

namespace Modules\Events\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Modules\Events\Entities\Event;
use Modules\Events\Entities\Guest;
use Modules\Events\Entities\SubGuest;
use Modules\Sms\Entities\SmsReminderTypes;
use Modules\Sms\Entities\SmsTemplate;
use Modules\Sms\Entities\SmsAccount;
use Modules\Email\Entities\EmailReminderTypes;
use Modules\Email\Entities\EmailTemplate;
use Twilio\Rest\Client;

class BirthdayGreeting extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'events:guest-birthday-greetings';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for email reminder to be sent to guests that have a birthday.';
    protected $email_template;
    protected $sms_account;
    protected $sms_template;
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    public function birthdayGreetingToMainGuest($guest) {
        Mail::send([], [], function($message) use($guest) {
            $body = $this->email_template->description;
            $body = str_replace('%guest_fullname%', $guest->fullname, $body);
            $body = str_replace('%guest_email%', $guest->email, $body);

            $sender_address = config('mail.from.address');
            $sender_name = config('mail.from.name');

            $message->from($sender_address, $sender_name)
                ->to($guest->email)
                ->subject($this->email_template->subject)
                ->setBody($body, "text/html");
        });
        $user = $guest->event->user;
        if ($user->sms_status && $user->sms_balance > $this->sms_account->sms_fee) {
            $user->update(["sms_balance" => ($user->sms_balance - $this->sms_account->sms_fee)]);
        
            $client = new Client($this->sms_account->twilio_sid, $this->sms_account->twilio_token);

            $body = $this->sms_template->description;
            $body = str_replace('%guest_fullname%', $guest->fullname, $body);
            $body = str_replace('%guest_email%', $guest->email, $body);
            
            $client->messages->create($guest->phone, [
                "from" => $this->sms_account->twilio_number,
                "body" => $body
            ]);
        }
    }

    public function birthdayGreetingToSubGuest($guest) {
        Mail::send([], [], function($message) use($guest) {
            $body = $this->email_template->description;
            $body = str_replace('%guest_fullname%', $guest->fullname, $body);
            $body = str_replace('%guest_email%', $guest->email, $body);

            $sender_address = config('mail.from.address');
            $sender_name = config('mail.from.name');

            $message->from($sender_address, $sender_name)
                ->to($guest->email)
                ->subject($this->email_template->subject)
                ->setBody($body, "text/html");
        });

        $user = $guest->event->user;
        if ($user->sms_status && $user->sms_balance > $this->sms_account->sms_fee) {
            $user->update(["sms_balance" => ($user->sms_balance - $this->sms_account->sms_fee)]);
        
            $client = new Client($this->sms_account->twilio_sid, $this->sms_account->twilio_token);

            $body = $this->sms_template->description;
            $body = str_replace('%guest_fullname%', $guest->fullname, $body);
            $body = str_replace('%guest_email%', $guest->email, $body);
            
            $client->messages->create($guest->phone, [
                "from" => $this->sms_account->twilio_number,
                "body" => $body
            ]);
        }
    }
    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->sms_account = SmsAccount::first();
        $type = SmsReminderTypes::where(["type" => "Birthday Greeting"])->first();
        $this->sms_template = SmsTemplate::where(["reminder_id" => $type->id, "type" => "default"])->first();
        $type = EmailReminderTypes::where(["type" => "Birthday Greeting"])->first();
        $this->email_template = EmailTemplate::where(["reminder_id" => $type->id, "type" => "default"])->first();
        
        $month = date('m');
        $day = date('d');
        $guests = Guest::whereMonth("birthday", "=", $month)
            ->whereDay("birthday", "=", $day)
            ->get();
        foreach ($guests as $guest) {
            $this->birthdayGreetingToMainGuest($guest);
        }
        $subGuests = SubGuest::whereMonth("birthday", "=", $month)
            ->whereDay("birthday", "=", $day)
            ->get();
        foreach ($subGuests as $guest) {
            $this->birthdayGreetingToSubGuest($guest);
        }
    }
}
