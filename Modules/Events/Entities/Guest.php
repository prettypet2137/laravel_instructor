<?php

namespace Modules\Events\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Events\Entities\Event;
use Ramsey\Uuid\Uuid;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Module;
class Guest extends Model
{
    use HasFactory;

    protected $table = 'event_guests';

    protected $dates = [
        'joined_at',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_paid' => 'boolean',
        'info_items' => 'array',
    ];
  
    protected $fillable = [
        'user_id',
        'event_id',
        'fullname',
        'email',
        'birthday',
        'phone',
        'is_paid',
        'ticket_name',
        'ticket_price',
        'ticket_currency',
        'info_items',
        'status',
        'joined_at',
        'guest_code',
        'qr_code_image',
        'qr_code_key',
        'reference',
        'gateway',
        'options'
    ];

    public function event()
    {
        return $this->belongsTo(Event::class, 'event_id', 'id');
    }
    
    public function getTotalInCentsAttribute()
    {
        $arr_zero_decimal =  ['BIF','CLP','DJF','GNF','JPY','KMF','KRW','MGA','PYG','RWF','UGX','VND','VUV','XAF','XOF','XPF'];
        $ticket_cnts = $this->get_sub_guest_nums() + 1;
        if (!in_array($this->currency, $arr_zero_decimal)) {
            $total_price = $this->ticket_price * $ticket_cnts;
            $upsell_items = json_decode(session()->get("upsell_items"), true);
            if (!is_null($upsell_items) && count($upsell_items) > 0) {
                foreach ($upsell_items as $upsell_item) {
                    $total_price += $upsell_item["price"];
                }
            }
            return $total_price * 100;
        }
        return $this->ticket_price * $ticket_cnts;
    }

    public function getCheckoutUrl()
    {
        $link = route('events.public.checkout', ['guest_code' => $this->guest_code]);
        if(Module::find('Saas')) {
           if($this->custom_domain){
                $link = "http://".$this->custom_domain.'/checkout/'.$this->guest_code;
           }
        }
        return $link;
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function (Guest $model) {
            $uuid = Uuid::uuid1()->toString();
            $model->guest_code = $uuid;
            $model->qr_code_image = QrCode::generate(route('events.checkin', ['uuid' => $uuid]));
            $model->qr_code_key = \Str::random(8);
        });
    }

    public function sub_guests() {
        return $this->hasMany(SubGuest::class, "guest_id", "id");
    }

    public function get_sub_guest_nums() {
        return $this->sub_guests->count();
    }

    public function upsell_histories() {
        return $this->hasMany(UpsellHistory::class, "guest_id", "id");
    }
}
