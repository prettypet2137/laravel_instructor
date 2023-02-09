<?php

namespace Modules\ModulesManager\Entities;

use Illuminate\Database\Eloquent\Model;

class PurchaseManager extends Model
{
    protected $dates = [
        'created_at',
        'updated_at',
    ];
  
    protected $fillable = [
        'product_id',
        'product_name',
        'purchase_code',
        'email_username_purchase',
        'path_main',
        'version',
        'verify_type',
        'created_at',
        'updated_at',
    ];
    
}
