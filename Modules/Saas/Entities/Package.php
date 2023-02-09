<?php

namespace Modules\Saas\Entities;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Package extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'title',
        'description',
        'price',
        'interval',
        'interval_number',
        'settings',
        'is_featured',
        'is_active',
    ];

    protected $casts = [
        'settings'    => 'array',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];
    public function users()
    {
        return $this->hasMany('Modules\User\Entities\User');
    }

    public function getPlanIdAttribute()
    {
        return Str::lower(
            'plan-'
            . $this->id . '-'
            . Str::slug($this->title, '-') . '-'
            . $this->whole_price . '-'
            . $this->fraction_price . '-'
            . config('app.CURRENCY_CODE') . '-'
            . $this->interval
        );
    }
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function getPriceInCentsAttribute()
    {
        return $this->price * 100;
    }

    public function getWholePriceAttribute()
    {
        return floor($this->price);
    }

    public function getFractionPriceAttribute()
    {
        return ltrim(round($this->price - $this->whole_price, 2), '0.');
    }
    
    public function getNoEventsAttribute()
    {
        if (array_key_exists('no_events', $this->settings)) {
            return $this->settings['no_events'];
        }
        return 0;
    }
    public function getNoGuestsAttribute()
    {
        if (array_key_exists('no_guests', $this->settings)) {
            return $this->settings['no_guests'];
        }
        return 0;
    }

    public function getUnlimitedPremiumThemeAttribute()
    {
        if (array_key_exists("unlimited_premium_theme", $this->settings)) {
            return filter_var($this->settings['unlimited_premium_theme'], FILTER_VALIDATE_BOOLEAN);
        }
        return false;

    }
    public function getCustomFontsAttribute()
    {
        if (array_key_exists("custom_fonts", $this->settings)) {
            return filter_var($this->settings['custom_fonts'], FILTER_VALIDATE_BOOLEAN);
        }
        return false;

    }
    public function getCustomDomainAttribute()
    {
        if (array_key_exists("custom_domain", $this->settings)) {
            return filter_var($this->settings['custom_domain'], FILTER_VALIDATE_BOOLEAN);
        }
        return false;

    }
    public function getCustomHeaderFooterAttribute()
    {
        if (array_key_exists("custom_header_footer", $this->settings)) {
            return filter_var($this->settings['custom_header_footer'], FILTER_VALIDATE_BOOLEAN);
        }
        return false;

    }
    public function getRemoveBrandingAttribute()
    {
        if (array_key_exists("remove_branding", $this->settings)) {
            return filter_var($this->settings['remove_branding'], FILTER_VALIDATE_BOOLEAN);
        }
        return false;

    }

    public function getPermissionsAttribute()
    {
        $all_permissions = config('saas.PERMISSIONS');

        asort($all_permissions);

        $permissions = [];
        foreach ($all_permissions as $permission => $description) {
            $permissions[$permission] = [
                'description' => $description,
                'can'         => $this->hasPermissionTo($permission),
            ];
        }

        return $permissions;
    }

    public function hasPermissionTo($permission)
    {
        if (array_key_exists($permission, $this->settings)) {
            return $this->settings[$permission];
        }
        return false;
    }

    public static function boot() {
        parent::boot();
        static::deleting(function($package) { // before delete() method call this
             $package->users()->each(function($item) {
                $item->update([ 
                    'package_id' => null,
                    'package_ends_at' => null,
                ]);
             });
        });
    }

}
