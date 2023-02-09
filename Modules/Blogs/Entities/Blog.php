<?php

namespace Modules\Blogs\Entities;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = 'blogs';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'title',
        'slug',
        'category_id',
        'content_short',
        'content',
        'thumb',
        'title_seo',
        'description_seo',
        'keyword_seo',
        'time_read',
        'facebook_share',
        'linkedin_share',
        'twitter_share',
        'mail_share',
        'is_featured',
        'is_active',
    ];
    
    protected $casts = [
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', '=', 1);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', '=', 1);
    }

    public function getThumbLink()
    {
        if(isset($this->thumb)){
            return asset('/storage/blogs/thumbnails/' . $this->thumb);
        } else {
            return null;
        }
        
    }

    public function getPublishLink()
    {
        return route('blog', ['slug' => $this->slug, 'id' => $this->id]);
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
