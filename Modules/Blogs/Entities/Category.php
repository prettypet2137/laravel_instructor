<?php

namespace Modules\Blogs\Entities;

use Illuminate\Database\Eloquent\Model;
use Modules\Blogs\Entities\Blog;

class Category extends Model
{
    protected $table = 'blog_categories';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'name',
        'thumb',
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
            return asset('/storage/blogs/categories/' . $this->thumb);
        } else {
            return null;
        }
        
    }

    public function blogs()
    {
        return $this->hasMany(Blog::class, 'category_id', 'id');
    }
}
