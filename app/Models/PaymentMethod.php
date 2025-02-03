<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    protected $table = 'payment_methods';
    protected $fillable = [
        'title',
        'description',
        'needs_payment',
        'is_active'
    ];

    public static function getActiveMethods()
    {
        return DeliveryMethod::query()
                             ->where('is_active','=',true)
                             ->get();
    }
}
