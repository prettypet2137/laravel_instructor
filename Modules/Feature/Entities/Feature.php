<?php

namespace Modules\Feature\Entities;

use Illuminate\Database\Eloquent\Model;

class Feature extends Model
{
    protected $fillable = [
        "user_id",
        "title",
        "content",
        "is_read"
    ];

    public function user() {
        return $this->hasOne(\Modules\User\Entities\User::class, "id", "user_id");
    }
}
