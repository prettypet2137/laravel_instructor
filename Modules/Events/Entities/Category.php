<?php

namespace Modules\Events\Entities;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Modules\Events\Entities\Event;

class Category extends Model
{
    use HasFactory;

    protected $table = 'event_categories';

    protected $dates = [
        'created_at',
        'updated_at',
    ];
  
    protected $fillable = [
        'name',
    ];

    public function events()
    {
        return $this->hasMany(Event::class, 'category_id', 'id');
    }
}
