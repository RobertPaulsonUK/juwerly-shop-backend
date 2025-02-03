<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryMethod extends Model
{
    protected $table = 'delivery_methods';
    protected $fillable = [
        'title',
        'description',
        'fixed_price',
        'free_shipping_price',
        'is_active'
    ];


    public static function getActiveMethods()
    {
        return DeliveryMethod::query()
                             ->where('is_active','=',true)
                             ->get();
    }
}
