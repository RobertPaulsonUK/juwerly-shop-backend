<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GiftDiscount extends Model
{
    protected $table = 'gift_discounts';

    protected $fillable = [
        'title',
        'description',
        'image_url',
        'product_id',
        'threshold',
        'start',
        'end',
        'is_active'
    ];

    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
