<?php

namespace Modules\Sms\Entities;

use Illuminate\Database\Eloquent\Model;

class SmsHistories extends Model
{
    protected $fillable = ["user_id", "reminder_type_id", "receiver_number", "message"];
    public function reminder_type() {
        return $this->hasOne(SmsReminderTypes::class, "id", "reminder_type_id");
    }
}
