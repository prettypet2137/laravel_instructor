<?php

namespace Modules\Events\Entities;

use Illuminate\Database\Eloquent\Model;

class SubGuest extends Model
{
    protected $dates = [
        'joined_at',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'info_items' => 'array',
    ];
    protected $fillable = [
        "guest_id",
        "fullname",
        "email",
        "birthday",
        "phone",
        "info_items",
        "joined_at"
    ];
}
