<?php

namespace Modules\Settings\Entities;

use Illuminate\Database\Eloquent\Model;

class ContentManagement extends Model
{
    protected $table = 'content_management';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'page',
        'title',
        'slug',
        'image',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', '=', 1);
    }

    public function getImage()
    {
        if (isset($this->image)) {
            return asset('/storage/content-management/' . $this->image);
        } else {
            return null;
        }

    }
}
