<?php

namespace Modules\Events\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\URL;
use Modules\Events\Entities\Category;
use Modules\Events\Entities\Guest;
use Carbon\Carbon;
use Modules\Tracklink\Entities\Tracklink;
use Module;
use Modules\User\Entities\User;

class Event extends Model
{
    use HasFactory;

    protected $table = 'events';

    protected $dates = [
        'register_end_date',
        'start_date',
        'created_at',
        'updated_at',
    ];
    protected $casts = [
        'info_items' => 'array',
        'ticket_items' => 'array',
        'upsells' => 'array',
        'seo_enable' => 'boolean',
    ];

    protected $fillable = [
        'name',
        'image',
        'tagline',
        'user_id',
        'category_id',
        'quantity',
        'register_end_date',
        'start_date',
        'end_date',
        'type',
        'address',
        'description',
        'noti_register_success',
        'email_content',
        'email_subject',
        'email_sender_name',
        'email_sender_email',
        'second_email_subject',
        'second_email_content',
        'second_email_attach',
        'second_email_status',
        'short_slug',
        'info_items',
        'ticket_items',
        'ticket_currency',
        'upsells',

        'theme',
        'theme_color',
        'background',
        'font_family',
        'custom_header',
        'custom_footer',

        'favicon',
        'custom_domain',
        'seo_enable',
        'seo_title',
        'seo_description',
        'seo_keywords',
        'social_title',
        'social_image',
        'social_description',
        'is_listing',
        'event_id',
        'is_recur',
        'recur_day',
        'recur_week',
        'recur_end_date',
        'terms_and_conditions'
    ];

    public function user()
    {
        return $this->belongsTo('Modules\User\Entities\User');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }

    public function guests()
    {
        return $this->hasMany(Guest::class, 'event_id', 'id');
    }

    public function tracklinks()
    {
        return $this->hasMany(Tracklink::class, 'target_id', 'id')->where('target_class', '=', Job::class);
    }

    public function getPublicUrl($name = null)
    {
        $user = User::whereRaw('TRIM(LOWER(name)) = ? ', trim(strtolower($name)))->first();
        if (empty($user)) {
            $user = $this->user;
        }
        if (empty($user)) {
            $user = auth()->user();
        }
        $event_link = route('events.public.show', ['name' => getSlugName($user->name), 'slug' => $this->short_slug]);
        if (Module::find('Saas')) {
            if ($this->custom_domain) {
                $event_link = "http://" . $this->custom_domain;
            }
        }
        return $event_link;
    }

    public function getImage()
    {
        if (!empty($this->image)) {
            return URL::to('/') . '/storage/' . $this->image;
        } else {
            return null;
        }
    }

    public function eventRegistrationExpired() {
        $now = Carbon::now();
        $check = $now > $this->register_end_date ? true : false;
        return $check;
    }
    
    public function eventExpired()
    {
        $now = Carbon::now();
        $check = $now > $this->end_date ? true : false;
        return $check;
    }

    public function getRules()
    {

        $rules = [
            'fullname' => ['required'],
            'email' => ['required'],
            'ticket' => []
        ];

        if (count($this->info_items) > 0) {
            $info_cnt = count($this->info_items['name']);
            for ($i = 0; $i < $info_cnt; $i++) {
                $values_raw = $this->info_items['values'][$i];
                $values = explode(',', $values_raw);

                $item_rules = [];

                if ($this->info_items['is_required'][$i] == '1') {
                    array_push($item_rules, 'required');
                } else {
                    array_push($item_rules, 'nullable');
                }

                switch ($this->info_items['data_type'][$i]) {
                    case 'text':
                        // 
                        break;
                    case 'textarea':
                        // 
                        break;
                    case 'select':
                        array_push($item_rules, 'in:' . $values_raw);
                        break;
                    default:
                        //
                        break;
                }

                $rules['info_item_' . $i] = $item_rules;
            }
        }
        return $rules;
    }
    
    public function events() {
        return $this->hasMany(Event::class, 'event_id', 'id');
    }

    public function event() {
        return $this->belongsTo(Event::class, 'event_id');
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function ($item) {
            $item->guests()->delete();
        });
    }
    
    public static function booted() {
        parent::booted();
        static::updated(function($event) {
            $event->events()->delete();
            if ($event->is_recur) {
                $registerEndDate = Carbon::parse($event->register_end_date);
                $startDate = Carbon::parse($event->start_date);
                $endDate = Carbon::parse($event->end_date);
                $recurEndDate = Carbon::parse($event->recur_end_date);
                $dayOfStartDate = $startDate->dayOfWeek;
                $i = 0;
                while($recurEndDate->diffInDays($startDate) > $event->recur_week * 7) {
                    if ($i == 0) {
                        $registerEndDate->addWeeks($event->recur_week)->addDays($event->recur_day - $dayOfStartDate);
                        $startDate->addWeeks($event->recur_week)->addDays($event->recur_day - $dayOfStartDate);
                        $endDate->addWeeks($event->recur_week)->addDays($event->recur_day - $dayOfStartDate);
                    } else {
                        $registerEndDate->addWeeks($event->recur_week);
                        $startDate->addWeeks($event->recur_week);
                        $endDate->addWeeks($event->recur_week);
                    }
                    $recurEvent = $event->replicate();
                    $recurEvent->short_slug = \Auth::user()->id . uniqid();
                    $recurEvent->event_id = $event->id;
                    $recurEvent->register_end_date = $registerEndDate;
                    $recurEvent->start_date = $startDate;
                    $recurEvent->end_date = $endDate;
                    $recurEvent->is_recur = 0;
                    $recurEvent->recur_day = null;
                    $recurEvent->recur_week = null;
                    $recurEvent->recur_end_date = null;
                    $recurEvent->info_items = $recurEvent->info_items;
                    $recurEvent->ticket_items = $recurEvent->ticket_items;
                    $recurEvent->upsells = $recurEvent->upsells;
                    $recurEvent->save();
                    $i++;
                }
            } 
        });
    }

}
