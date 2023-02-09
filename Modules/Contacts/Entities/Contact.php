<?php

namespace Modules\Contacts\Entities;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $table = 'contacts';

    protected $dates = [
        'created_at',
        'updated_at',
    ];

    protected $fillable = [
        'fullname',
        'phone',
        'email',
        'subject',
        'content',
        'is_readed',
    ];
    
    protected $casts = [
        'is_readed' => 'boolean',
    ];

    public function scopeReaded($query)
    {
        return $query->where('is_readed', '=', 1);
    }
}
