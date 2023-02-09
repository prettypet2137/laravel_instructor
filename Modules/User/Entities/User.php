<?php

namespace Modules\User\Entities;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Modules\User\Notifications\QueuedResetPassword;
use Lab404\Impersonate\Models\Impersonate;

class User extends Authenticatable
{
    use Notifiable, Impersonate;

    protected $dates = [
        'email_verified_at',
        'package_ends_at',
        'created_at',
        'updated_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'role',
        'name',
        'company',
        'email',
        'email_verified_at',
        'password',
        'remember_token',
        'settings',
        'package_id',
        'package_ends_at',
        'sms_status',
        'sms_balance',
        'is_show_about_us_form',
        'is_show_contact_us_form'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'settings' => 'array'
    ];
    
    public function scopeUser($query)
    {
        return $query->where('role', '=', 'user');
    }

    public function payments()
    {
        return $this->hasMany('Modules\Saas\Entities\Payment');
    }

    public function package()
    {
        return $this->belongsTo('Modules\Saas\Entities\Package')->withDefault();
    }

    public function events()
    {
        return $this->hasMany('Modules\Events\Entities\Event');
    }

    public function subscribed()
    {
        if (is_null($this->package_ends_at)) {
            return false;
        }
        return $this->package_ends_at->isFuture();
    }
    
    public function allowCustomFonts()
    {
        if (!$this->subscribed()) {
            # code...
            if (config('saas.custom_fonts') == true) {
                return true;
            }
            return false;
        }
        else{
            if ($this->package->custom_fonts == true) {
                return true;
            }
            return false;
        }
    }
    public function allowRemoveBrand()
    {
        if (!$this->subscribed()) {
            # code...
            if (config('saas.remove_branding') == true) {
                return true;
            }
            return false;
        }
        else{
            if ($this->package->remove_branding == true) {
                return true;
            }
            return false;
        }
    }

    public function allowCustomDomain()
    {
        if (!$this->subscribed()) {
            # code...
            if (config('saas.custom_domain') == true) {
                return true;
            }
            return false;
        }
        else{
            if ($this->package->custom_domain == true) {
                return true;
            }
            return false;
        }
    }

    public function allowPremiumTheme()
    {
        if (!$this->subscribed()) {
            # code...
            if (config('saas.unlimited_premium_theme') == true) {
                return true;
            }
            return false;
        }
        else{
            if ($this->package->unlimited_premium_theme == true) {
                return true;
            }
            return false;
        }
    }

    public function allowCustomHeaderFooter()
    {
        if (!$this->subscribed()) {
            # code...
            if (config('saas.custom_header_footer') == true) {
                return true;
            }
            return false;
        }
        else{
            if ($this->package->custom_header_footer == true) {
                return true;
            }
            return false;
        }
    }

    public function sendPasswordResetNotification($token)
    {
        $this->notify(new QueuedResetPassword($token));
    }

    public static function boot() {
        parent::boot();
        static::deleting(function($user) {
       });
    }
    
}
