<?php

namespace Modules\Sms\Entities;

use Illuminate\Database\Eloquent\Model;

class SmsAccount extends Model
{
    protected $fillable = [
        "twilio_sid",
        "twilio_token",
        "twilio_number",
        "sms_fee"
    ];
}
