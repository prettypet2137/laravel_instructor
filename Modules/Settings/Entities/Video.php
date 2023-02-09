<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    protected $fillable = [
        "link",
        "title",
        "description"
    ];
}
