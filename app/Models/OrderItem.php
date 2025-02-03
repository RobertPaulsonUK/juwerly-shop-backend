<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderItem extends Model
{
    protected $table = 'order_items';
    protected $fillable = [
        'name',
        'url',
        'image_url',
        'quantity',
        'price',
        'order_id',
    ];

    public function order():BelongsTo
    {
        return $this->belongsTo(Order::class,'order_id','id');
    }
}
