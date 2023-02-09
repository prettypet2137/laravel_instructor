<?php

namespace Modules\Events\Entities;

use Illuminate\Database\Eloquent\Model;

class EventCategory extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'type'
    ];
}
