<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartGift extends Model
{
    protected $table = 'cart_gifts';
    protected $fillable = [
        'cart_id',
        'product_id'
    ];

    public function cart():BelongsTo
    {
        return $this->belongsTo(Cart::class,'cart_id','id');
    }

    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class,'product_id','id');
    }

    public function prepareDataForOrder():array
    {
        $product = $this->product;
        return [
            'name' => $product->name,
            'url' => $product->url,
            'image_url' => $product->main_image_url,
            'quantity' => 1,
            'price' => $product->price,
        ];
    }
}
