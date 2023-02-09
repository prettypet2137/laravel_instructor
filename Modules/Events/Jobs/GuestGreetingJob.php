<?php

namespace Modules\Events\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Modules\Events\Entities\Event;
use Modules\Events\Entities\Guest;
use Modules\Sms\Entities\SmsReminderTypes;
use Modules\Sms\Entities\SmsTemplate;
use Modules\Sms\Entities\SmsAccount;
use Twilio\Rest\Client;


class GuestGreetingJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $event;
    protected $guest;
    protected $sms_account;
    protected $sms_template;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(Event $event, Guest $guest)
    {
        $this->event = $event;
        $this->guest = $guest;
    }

    public function orderCompleteToMainGuest($event, $guest) {
        Mail::send([], [], function ($message) use ($event, $guest) {
            $body = $event->email_content;

            $body = str_replace('%event_name%', $event->name, $body);
            $body = str_replace('%event_description%', $event->description, $body);
            $body = str_replace('%guest_fullname%', $guest->fullname, $body);
            $body = str_replace('%guest_email%', $guest->email, $body);
            $body = str_replace('%guest_ticket_name%', $guest->ticket_name, $body);
            $body = str_replace('%guest_ticket_price%', $guest->ticket_price, $body);
            $body = str_replace('%guest_ticket_currency%', $guest->ticket_currency, $body);

            $body = str_replace('%event_address%', $event->address, $body);
            $body = str_replace('%qr_code%', '<a href="https://1da.sh/e/' . $guest->qr_code_key . '">QR Code</a>', $body);

            if ($event->start_date) {
                $body = str_replace('%event_start_date%', $event->start_date->format('Y-m-d H:i:s'), $body);
            }
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
                ->subject($event->email_subject)
                ->setBody($body, 'text/html');
        });
        $user = $this->event->user;
        if ($user->sms_status && $user->sms_balance > $this->sms_account->sms_fee) {
            $user->update(["sms_balance" => ($user->sms_balance - $this->sms_account->sms_fee)]);
            $client = new Client($this->sms_account->twilio_sid, $this->sms_account->twilio_token);
            
            $body = $this->sms_template->description;
            $body = str_replace('%event_name%', $event->name, $body);
            $body = str_replace('%event_description%', $event->description, $body);
            $body = str_replace('%guest_fullname%', $guest->fullname, $body);
            $body = str_replace('%guest_email%', $guest->email, $body);
            $body = str_replace('%guest_ticket_name%', $guest->ticket_name, $body);
            $body = str_replace('%guest_ticket_price%', $guest->ticket_price, $body);
            $body = str_replace('%guest_ticket_currency%', $guest->ticket_currency, $body);
            if ($event->second_email_attach) {
                $body = str_replace("%document_download_url%", "https://1da.sh/storage/" . $event->second_email_attach, $body);
            }
            $body = str_replace('%event_address%', $event->address, $body);
            if ($event->start_date)
                $body = str_replace('%event_start_date%', $event->start_date->format('Y-m-d H:i:s'), $body);
            $body .= "You can confirm the QR code for the ticket following url. https://1da.sh/e/" . $guest->qr_code_key;
            try {
                $client->messages->create($guest->phone, [
                    "from" => $this->sms_account->twilio_number,
                    "body" => $body
                ]);
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
        }
    }

    public function orderCompleteToSubGuest($event, $guest, $sub_guest) {
        // SENDING EMAIL
        Mail::send([], [], function ($message) use ($event, $guest, $sub_guest) {
            $body = $event->email_content;
            $body = str_replace('%event_name%', $event->name, $body);
            $body = str_replace('%event_description%', $event->description, $body);
            $body = str_replace('%guest_fullname%', $sub_guest->fullname, $body);
            $body = str_replace('%guest_email%', $sub_guest->email, $body);
            $body = str_replace('%guest_ticket_name%', $guest->ticket_name, $body);
            $body = str_replace('%guest_ticket_price%', $guest->ticket_price, $body);
            $body = str_replace('%guest_ticket_currency%', $guest->ticket_currency, $body);

            $body = str_replace('%event_address%', $event->address, $body);
            $body = str_replace('%qr_code%', '<a href="https://1da.sh/e/' . $guest->qr_code_key . '">QR Code</a>', $body);
            if ($event->start_date)
                $body = str_replace('%event_start_date%', $event->start_date->format('Y-m-d H:i:s'), $body);

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
                ->to($sub_guest->email)
                ->subject($event->email_subject)
                ->setBody($body, 'text/html');
        });

        $user = $this->event->user;
        if ($user->sms_status && $user->sms_balance > $this->sms_account->sms_fee) {
            $user->update(["sms_balance" => ($user->sms_balance - $this->sms_account->sms_fee)]);
            // SENDING SMS
            $client = new Client($this->sms_account->twilio_sid, $this->sms_account->twilio_token);
            
            $body = $this->sms_template->description;
            $body = str_replace('%event_name%', $event->name, $body);
            $body = str_replace('%event_description%', $event->description, $body);
            $body = str_replace('%guest_fullname%', $sub_guest->fullname, $body);
            $body = str_replace('%guest_email%', $sub_guest->email, $body);
            $body = str_replace('%guest_ticket_name%', $guest->ticket_name, $body);
            $body = str_replace('%guest_ticket_price%', $guest->ticket_price, $body);
            $body = str_replace('%guest_ticket_currency%', $guest->ticket_currency, $body);
            $body = str_replace("%document_download_url%", "https://1da.sh/storage/" . $event->second_email_attach, $body);
            $body = str_replace('%event_address%', $event->address, $body);
            if ($event->start_date)
                $body = str_replace('%event_start_date%', $event->start_date->format('Y-m-d H:i:s'), $body);
            $body .= "You can confirm the QR code for the ticket following url. https://1da.sh/e/" . $guest->qr_code_key;
            try {
                $client->messages->create($sub_guest->phone, [
                    "from" => $this->sms_account->twilio_number,
                    "body" => $body
                ]); 
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
        }
    }

    public function secondRegistrationToMainGuest($event, $guest) {
        // SEND EMAIL
        Mail::send([], [], function ($message) use($event, $guest) {
            $body = $event->second_email_content;
            $body = str_replace("%event_name%", $event->name, $body);
            $body = str_replace('%event_description%', $event->description, $body);
            $body = str_replace('%guest_fullname%', $guest->fullname, $body);
            $body = str_replace('%guest_email%', $guest->email, $body);
            $body = str_replace('%guest_ticket_name%', $guest->ticket_name, $body);
            $body = str_replace('%guest_ticket_price%', $guest->ticket_price, $body);
            $body = str_replace('%guest_ticket_currency%', $guest->ticket_currency, $body);
            $body = str_replace("%document_download_url%", "https://1da.sh/storage/" . $event->second_email_attach, $body);
            $body = str_replace('%event_address%', $event->address, $body);
            if ($event->start_date) $body = str_replace('%event_start_date%', $event->start_date->format('Y-m-d H:i:s'), $body);

            $sender_address = config('mail.from.address');
            $sender_name = config('mail.from.name');
    
            $message
                ->from($sender_address, $sender_name)
                ->to($guest->email)
                ->subject($event->second_email_subject)
                ->setBody($body, 'text/html');
        });

        $user = $this->event->user;
        if ($user->sms_status && $user->sms_balance > $this->sms_account->sms_fee) {
            $user->update(["sms_balance" => ($user->sms_balance - $this->sms_account->sms_fee)]);
            // SEND SMS
            $client = new Client($this->sms_account->twilio_sid, $this->sms_account->twilio_token);
            
            $body = $this->sms_template->description;
            $body = str_replace('%event_name%', $event->name, $body);
            $body = str_replace('%event_description%', $event->description, $body);
            $body = str_replace('%guest_fullname%', $guest->fullname, $body);
            $body = str_replace('%guest_email%', $guest->email, $body);
            $body = str_replace('%guest_ticket_name%', $guest->ticket_name, $body);
            $body = str_replace('%guest_ticket_price%', $guest->ticket_price, $body);
            $body = str_replace('%guest_ticket_currency%', $guest->ticket_currency, $body);
            $body = str_replace("%document_download_url%", "https://1da.sh/storage/" . $event->second_email_attach, $body);
            $body = str_replace('%event_address%', $event->address, $body);
            if ($event->start_date) $body = str_replace('%event_start_date%', $event->start_date->format('Y-m-d H:i:s'), $body);
            if ($event->second_email_attach) {
                $body .= " You can check following url. https://1da.sh/storage/" . $event->second_email_attach;
            }
            try {
                $client->messages->create($guest->phone, [
                    "from" => $this->sms_account->twilio_number,
                    "body" => $body
                ]);
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
        }
    }

    public function secondRegistrationToSubGuest($event, $guest, $sub_guest) {
        // SEND EMAIL
        Mail::send([], [], function ($message) use($event, $guest, $sub_guest) {
            $body = $event->second_email_content;
            $body = str_replace("%event_name%", $event->name, $body);
            $body = str_replace('%event_description%', $event->description, $body);
            $body = str_replace('%guest_fullname%', $sub_guest->fullname, $body);
            $body = str_replace('%guest_email%', $sub_guest->email, $body);
            $body = str_replace('%guest_ticket_name%', $guest->ticket_name, $body);
            $body = str_replace('%guest_ticket_price%', $guest->ticket_price, $body);
            $body = str_replace('%guest_ticket_currency%', $guest->ticket_currency, $body);
            $body = str_replace("%document_download_url%", "https://1da.sh/storage/" . $event->second_email_attach, $body);
            $body = str_replace('%event_address%', $event->address, $body);
            if ($event->start_date) $body = str_replace('%event_start_date%', $event->start_date->format('Y-m-d H:i:s'), $body);
            $body = str_replace('%qr_code%', '<a href="https://1da.sh/e/' . $guest->qr_code_key . '">QR Code</a>', $body);

            $sender_address = config('mail.from.address');
            $sender_name = config('mail.from.name');

            $message
                ->from($sender_address, $sender_name)
                ->to($sub_guest->email)
                ->subject($event->second_email_subject)
                ->setBody($body, 'text/html');
        });
        $user = $this->event->user;
        if ($user->sms_status && $user->sms_balance > $this->sms_account->sms_fee) {
            // SEND SMS
            $client = new Client($this->sms_account->twilio_sid, $this->sms_account->twilio_token);
            
            $body = $this->sms_template->description;
            $body = str_replace('%event_name%', $event->name, $body);
            $body = str_replace('%event_description%', $event->description, $body);
            $body = str_replace('%guest_fullname%', $sub_guest->fullname, $body);
            $body = str_replace('%guest_email%', $sub_guest->email, $body);
            $body = str_replace('%guest_ticket_name%', $guest->ticket_name, $body);
            $body = str_replace('%guest_ticket_price%', $guest->ticket_price, $body);
            $body = str_replace('%guest_ticket_currency%', $guest->ticket_currency, $body);
            $body = str_replace("%document_download_url%", "https://1da.sh/storage/" . $event->second_email_attach, $body);
            $body = str_replace('%event_address%', $event->address, $body);
            if ($event->start_date) $body = str_replace('%event_start_date%', $event->start_date->format('Y-m-d H:i:s'), $body);
            $body .= " You can check following url. https://1da.sh/storage/" . $event->second_email_attach;
            try {
                $client->messages->create($sub_guest->phone, [
                    "from" => $this->sms_account->twilio_number,
                    "body" => $body
                ]);
            } catch (\Exception $e) {
                echo $e->getMessage();
            }
        }
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
        $this->sms_account = SmsAccount::first();
        $type = SmsReminderTypes::where(["type" => "Order Completed"])->first();
        $sms_template = SmsTemplate::where(["reminder_id" => $type->id, "user_id" => $guest->user_id])->first();
        if (is_null($sms_template)) {
            $sms_template = SmsTemplate::where(["reminder_id" => $type->id, "type" => "default"])->first();
        }
        $this->sms_template = $sms_template;
        $this->orderCompleteToMainGuest($event, $guest);
        $sub_guests = $guest->sub_guests;
        foreach ($sub_guests as $sub_guest) {
            $this->orderCompleteToSubGuest($event, $guest, $sub_guest);
        }
        if ((int) $event->second_email_status != 0) {
            $this->secondRegistrationToMainGuest($event, $guest);
            foreach ($sub_guests as $sub_guest) {
                $this->secondRegistrationToSubGuest($event, $guest, $sub_guest);
            }
        }
    }
}