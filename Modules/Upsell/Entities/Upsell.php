<?php

namespace Modules\Upsell\Entities;

use Illuminate\Database\Eloquent\Model;

class Upsell extends Model
{
    protected $fillable = [
        "user_id",
        "title",
        "price",
        "image",
        "description"
    ];

    public function getPrices() {
        return json_decode($this->price);
    }
}
