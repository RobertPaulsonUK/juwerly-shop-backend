<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OnePlusOneDiscount extends Model
{
    protected $table = 'one_plus_one_discounts';
    protected $fillable = [
        'title',
        'description',
        'image_url',
        'start',
        'end',
        'product_id',
        'is_active'
    ];

    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }
}
