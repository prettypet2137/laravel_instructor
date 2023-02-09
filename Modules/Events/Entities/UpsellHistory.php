<?php

namespace Modules\Events\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Upsell\Entities\Upsell;

class UpsellHistory extends Model
{
    protected $fillable = [
        "event_id", "guest_id", "upsell_id", "price"
    ];

    public function upsell() {
        return $this->belongsTo(Upsell::class, "upsell_id", "id");
    }
}
