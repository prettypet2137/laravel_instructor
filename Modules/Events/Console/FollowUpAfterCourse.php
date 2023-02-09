<?php

namespace Modules\Events\Console;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Input\InputArgument;
use Illuminate\Support\Facades\Mail;
use Modules\Events\Entities\Event;
use Modules\Sms\Entities\SmsReminderTypes;
use Modules\Sms\Entities\SmsTemplate;
use Modules\Sms\Entities\SmsAccount;
use Modules\Email\Entities\EmailReminderTypes;
use Modules\Email\Entities\EmailTemplate;
use Twilio\Rest\Client;

class FollowUpAfterCourse extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'events:follow-up-after-course';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command for email reminder to be sent guests after they completed event.';
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

    public function followUpAfterCourseToMainGuest($event, $guest) {
        Mail::send([], [], function($message) use($event, $guest) {
            $body = $this->email_template->description;
            $body = str_replace("%event_name%", $event->name, $body);
            $body = str_replace('%event_description%', $event->description, $body);
            $body = str_replace('%guest_fullname%', $guest->fullname, $body);
            $body = str_replace('%guest_email%', $guest->email, $body);
            $body = str_replace('%guest_ticket_name%', $guest->ticket_name, $body);
            $body = str_replace('%guest_ticket_price%', $guest->ticket_price, $body);
            $body = str_replace('%guest_ticket_currency%', $guest->ticket_currency, $body);
            $body = str_replace("%document_download_url%", url("storage/" . $event->second_email_attach), $body);
            $body = str_replace('%event_address%', $event->address, $body);
            if ($event->start_date) $body = str_replace('%event_start_date%', $event->start_date->format('Y-m-d H:i:s'), $body);

            $sender_address = config('mail.from.address');
            $sender_name = config('mail.from.name');

            $message->from($sender_address, $sender_name)
                ->to($guest->email)
                ->subject($this->email_template->subject)
                ->setBody($body, "text/html");
        });

        $user = $event->user;
        if ($user->sms_status && $user->sms_balance > $this->sms_account->sms_fee) {
            $user->update(["sms_balance" => ($user->sms_balance - $this->sms_account->sms_fee)]);

            $client = new Client($this->sms_account->twilio_sid, $this->sms_account->twilio_token);

            $body = $this->sms_template->description;
            $body = str_replace("%event_name%", $event->name, $body);
            $body = str_replace('%event_description%', $event->description, $body);
            $body = str_replace('%guest_fullname%', $guest->fullname, $body);
            $body = str_replace('%guest_email%', $guest->email, $body);
            $body = str_replace('%guest_ticket_name%', $guest->ticket_name, $body);
            $body = str_replace('%guest_ticket_price%', $guest->ticket_price, $body);
            $body = str_replace('%guest_ticket_currency%', $guest->ticket_currency, $body);
            $body = str_replace("%document_download_url%", url("storage/" . $event->second_email_attach), $body);
            $body = str_replace('%event_address%', $event->address, $body);
            if ($event->start_date) $body = str_replace('%event_start_date%', $event->start_date->format('Y-m-d H:i:s'), $body);
            
            $client->messages->create($guest->phone, [
                "from" => $this->sms_account->twilio_number,
                "body" => $body
            ]);
        }
    }

    public function followUpAfterCourseToSubGuest($event, $guest, $sub_guest) {
        Mail::send([], [], function($message) use($event, $guest, $sub_guest) {
            $body = $this->email_template->description;
            $body = str_replace("%event_name%", $event->name, $body);
            $body = str_replace('%event_description%', $event->description, $body);
            $body = str_replace('%guest_fullname%', $sub_guest->fullname, $body);
            $body = str_replace('%guest_email%', $sub_guest->email, $body);
            $body = str_replace('%guest_ticket_name%', $guest->ticket_name, $body);
            $body = str_replace('%guest_ticket_price%', $guest->ticket_price, $body);
            $body = str_replace('%guest_ticket_currency%', $guest->ticket_currency, $body);
            $body = str_replace("%document_download_url%", url("storage/" . $event->second_email_attach), $body);
            $body = str_replace('%event_address%', $event->address, $body);
            if ($event->start_date) $body = str_replace('%event_start_date%', $event->start_date->format('Y-m-d H:i:s'), $body);

            $sender_address = config('mail.from.address');
            $sender_name = config('mail.from.name');

            $message->from($sender_address, $sender_name)
                ->to($sub_guest->email)
                ->subject($this->email_template->subject)
                ->setBody($body, "text/html");
        });

        $user = $event->user;
        if ($user->sms_status && $user->sms_balance > $this->sms_account->sms_fee) {
            $user->update(["sms_balance" => ($user->sms_balance - $this->sms_account->sms_fee)]);
         
            $client = new Client($this->sms_account->twilio_sid, $this->sms_account->twilio_token);

            $body = $this->sms_template->description;
            $body = str_replace("%event_name%", $event->name, $body);
            $body = str_replace('%event_description%', $event->description, $body);
            $body = str_replace('%guest_fullname%', $sub_guest->fullname, $body);
            $body = str_replace('%guest_email%', $sub_guest->email, $body);
            $body = str_replace('%guest_ticket_name%', $guest->ticket_name, $body);
            $body = str_replace('%guest_ticket_price%', $guest->ticket_price, $body);
            $body = str_replace('%guest_ticket_currency%', $guest->ticket_currency, $body);
            $body = str_replace("%document_download_url%", url("storage/" . $event->second_email_attach), $body);
            $body = str_replace('%event_address%', $event->address, $body);
            if ($event->start_date) $body = str_replace('%event_start_date%', $event->start_date->format('Y-m-d H:i:s'), $body);
            
            $client->messages->create($sub_guest->phone, [
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
        $type = SmsReminderTypes::where(["type" => "Follow Up After Course"])->first();
        $this->sms_template = SmsTemplate::where(["reminder_id" => $type->id, "type" => "default"])->first();
        $type = EmailReminderTypes::where(["type" => "Follow Up After Course"])->first();
        $this->email_template = EmailTemplate::where(["reminder_id" => $type->id, "type" => "default"])->first();
        
        $dayAfter = date("Y-m-d", strtotime("-1 day"));
        Event::with("guests.sub_guests")->whereDate("start_date", "=", $dayAfter)->chunk(100, function ($events) {
            foreach ($events as $event) {
                if (count($event->guests)) {
                    foreach ($event->guests as $guest) {
                        $this->followUpAfterCourseToMainGuest($event, $guest);
                        if (count($guest->sub_guests)) {
                            foreach ($guest->sub_guests as $sub_guest) {
                                $this->followUpAfterCourseToSubGuest($event, $guest, $sub_guest);
                            }
                        }
                    }
                }
            }
        });
    }
}
