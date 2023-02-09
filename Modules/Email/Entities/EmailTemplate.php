<?php

namespace Modules\Email\Entities;

use Illuminate\Database\Eloquent\Model;

class EmailTemplate extends Model
{
    protected $fillable = [
        "reminder_id",
        "user_id",
        "type",
        "subject",
        "description"
    ];
}
