<?php

namespace Modules\Events\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Modules\Email\Entities\EmailReminderTypes;
use Modules\Email\Entities\EmailTemplate;
use Modules\Sms\Entities\SmsReminderTypes;
use Modules\Sms\Entities\SmsTemplate;
use Modules\Sms\Entities\SmsAccount;
use Twilio\Rest\Client;

class PaymentNotCompleted implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $event;
    protected $guest;
    protected $sms_account;
    protected $sms_template;
    protected $email_template;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($event, $guest)
    {
        $this->event = $event;
        $this->guest = $guest;
    }

    public function paymentNotCompleteToMainGuest() {
        Mail::send([], [], function($message) {
            $body = $this->email_template->description;
            $body = str_replace('%event_name%', $this->event->name, $body);
            $body = str_replace('%event_description%', $this->event->description, $body);
            $body = str_replace('%guest_fullname%', $this->guest->fullname, $body);
            $body = str_replace('%guest_email%', $this->guest->email, $body);
            $body = str_replace('%guest_ticket_name%', $this->guest->ticket_name, $body);
            $body = str_replace('%guest_ticket_price%', $this->guest->ticket_price, $body);
            $body = str_replace('%guest_ticket_currency%', $this->guest->ticket_currency, $body);
            $body = str_replace('%event_address%', $this->event->address, $body);
            if ($this->event->start_date) $body = str_replace('%event_start_date%', $this->event->start_date->format('Y-m-d H:i:s'), $body);
            $sender_address = config('mail.from.address');
            $sender_name = config('mail.from.name');

            if ($this->event->email_sender_email) $sender_address = $this->event->email_sender_email;
            if ($this->event->email_sender_name) $sender_name = $this->event->email_sender_name;

            $message->from($sender_address, $sender_name)
                ->to($this->guest->email)
                ->subject($this->email_template->subject)
                ->setBody($body, "text/html");
        });

        $user = $this->event->user;
        if ($user->sms_status && $user->sms_balance > $this->sms_account->sms_fee) {
            $user->update(["sms_balance" => ($user->sms_balance - $this->sms_account->sms_fee)]);
            $client = new Client($this->sms_account->twilio_sid, $this->sms_account->twilio_token);
            $body = $this->sms_template->description;
            $body = str_replace('%event_name%', $this->event->name, $body);
            $body = str_replace('%event_description%', $this->event->description, $body);
            $body = str_replace('%guest_fullname%', $this->guest->fullname, $body);
            $body = str_replace('%guest_email%', $this->guest->email, $body);
            $body = str_replace('%guest_ticket_name%', $this->guest->ticket_name, $body);
            $body = str_replace('%guest_ticket_price%', $this->guest->ticket_price, $body);
            $body = str_replace('%guest_ticket_currency%', $this->guest->ticket_currency, $body);
            $body = str_replace('%event_address%', $this->event->address, $body);
            if ($this->event->start_date)
                $body = str_replace('%event_start_date%', $this->event->start_date->format('Y-m-d H:i:s'), $body);
            
            $client->messages->create($this->guest->phone, [
                "from" => $this->sms_account->twilio_number,
                "body" => $body
            ]);
        }
    }

    public function paymentNotCompleteToSubGuest($sub_guest) {
        Mail::send([], [], function($message) use($sub_guest) {
            $body = $this->email_template->description;
            $body = str_replace('%event_name%', $this->event->name, $body);
            $body = str_replace('%event_description%', $this->event->description, $body);
            $body = str_replace('%guest_fullname%', $sub_guest->fullname, $body);
            $body = str_replace('%guest_email%', $sub_guest->email, $body);
            $body = str_replace('%guest_ticket_name%', $this->guest->ticket_name, $body);
            $body = str_replace('%guest_ticket_price%', $this->guest->ticket_price, $body);
            $body = str_replace('%guest_ticket_currency%', $this->guest->ticket_currency, $body);
            $body = str_replace('%event_address%', $this->event->address, $body);
            if ($this->event->start_date) $body = str_replace('%event_start_date%', $this->event->start_date->format('Y-m-d H:i:s'), $body);
            $sender_address = config('mail.from.address');
            $sender_name = config('mail.from.name');

            if ($this->event->email_sender_email) $sender_address = $this->event->email_sender_email;
            if ($this->event->email_sender_name) $sender_name = $this->event->email_sender_name;

            $message->from($sender_address, $sender_name)
                ->to($sub_guest->email)
                ->subject($this->email_template->subject)
                ->setBody($body, "text/html");
        });

        $user = $this->event->user;
        if ($user->sms_status && $user->sms_balance > $this->sms_account->sms_fee) {
            $user->update(["sms_balance" => ($user->sms_balance - $this->sms_account->sms_fee)]);
         
            $client = new Client($this->sms_account->twilio_sid, $this->sms_account->twilio_token);
            $body = $this->sms_template->description;
            $body = str_replace('%event_name%', $this->event->name, $body);
            $body = str_replace('%event_description%', $this->event->description, $body);
            $body = str_replace('%guest_fullname%', $sub_guest->fullname, $body);
            $body = str_replace('%guest_email%', $sub_guest->email, $body);
            $body = str_replace('%guest_ticket_name%', $this->guest->ticket_name, $body);
            $body = str_replace('%guest_ticket_price%', $this->guest->ticket_price, $body);
            $body = str_replace('%guest_ticket_currency%', $this->guest->ticket_currency, $body);
            $body = str_replace('%event_address%', $this->event->address, $body);
            if ($this->event->start_date)
                $body = str_replace('%event_start_date%', $this->event->start_date->format('Y-m-d H:i:s'), $body);
            
            $client->messages->create($sub_guest->phone, [
                "from" => $this->sms_account->twilio_number,
                "body" => $body
            ]);
        }
    }
    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->sms_account = SmsAccount::first();
        
        $type = SmsReminderTypes::where(["type" => "Payment Not Completed"])->first();
        $sms_template = SmsTemplate::where(["reminder_id" => $type->id, "user_id" => $this->event->user_id])->first();
        if (is_null($sms_template)) {
            $sms_template = SmsTemplate::where(["reminder_id" => $type->id, "type" => "default"])->first();
        }
        $this->sms_template = $sms_template;

        $type = EmailReminderTypes::where(["type" => "Payment Not Completed"])->first();
        $email_template = EmailTemplate::where(["reminder_id" => $type->id, "user_id" => $this->event->user_id])->first();
        if (is_null($email_template)) {
            $email_template = EmailTemplate::where(["reminder_id" => $type->id, "type" => "default"])->first();
        }
        $this->email_template = $email_template;
        
        if (!$this->guest->is_paid) {
            $this->paymentNotCompleteToMainGuest();
            foreach ($this->guest->sub_guests as $sub_guest) {
                $this->paymentNotCompleteToSubGuest($sub_guest);
            }
        }
    }
}
