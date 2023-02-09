<?php

namespace Modules\Email\Entities;

use Illuminate\Database\Eloquent\Model;

class EmailReminderTypes extends Model
{
    protected $fillable = [
        "type"
    ];

    public function templates() {
        return $this->hasMany(EmailTemplate::class, "reminder_id", "id");
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
