<?php

namespace Modules\Sms\Entities;

use Illuminate\Database\Eloquent\Model;

class SmsReminderTypes extends Model
{
    protected $table = "sms_reminder_types";
    public $timestamps = true;
    protected $fillable = [
        "type"
    ];

    public function templates() {
        return $this->hasMany(SmsTemplate::class, 'reminder_id', 'id');
    }

    public function getTemplate() {
        $template = $this->templates->where("user_id", auth()->id())->where("type", "customize")->first();
        if ($template) {
            return $template;
        } else {
            $template = $this->templates->where("type", "default")->first();
            if ($template) {
                return $template;
            } else {
                return [];
            }
        }
    }
}
