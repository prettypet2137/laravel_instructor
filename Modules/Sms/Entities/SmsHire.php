<?php

namespace Modules\Sms\Entities;

use Illuminate\Database\Eloquent\Model;

class SmsHire extends Model
{
    protected $fillable = ["amount", "is_active"];
}
