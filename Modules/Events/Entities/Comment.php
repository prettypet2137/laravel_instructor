<?php

namespace Modules\Events\Entities;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    protected $table = 'comment_users';

    protected $fillable = [
        'name',
        'email',
        'description',
        'user_id'
    ];

    protected $dates = [
        'created_at',
        'updated_at',
    ];
}
