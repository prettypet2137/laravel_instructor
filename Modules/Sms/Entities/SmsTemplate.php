<?php

namespace Modules\Sms\Entities;

use Illuminate\Database\Eloquent\Model;

class SmsTemplate extends Model
{
    protected $fillable = [
        "reminder_id",
        "user_id",
        "type",
        "subject",
        "description"
    ];
}
