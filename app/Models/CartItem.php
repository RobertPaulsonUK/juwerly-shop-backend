<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CartItem extends Model
{
    protected $table = 'cart_items';
    protected $fillable = [
        'cart_id',
        'product_id',
        'variation_id',
        'quantity'
    ];
    public function product():BelongsTo
    {
        return $this->variation_id !== null ?
            $this->belongsTo(Variation::class,'variation_id','id')
            :
            $this->belongsTo(Product::class,'product_id','id');
    }

    public function getPriceAttribute():int
    {
        $product = $this->product;

        return $product->sale_price > 0 ? $product->sale_price : $product->price;
    }
    public function getNameAttribute():string
    {
        return  $this->product->name;
    }
    public function getUrlAttribute():string
    {
        return  $this->product->url;
    }
    public function getImageUrlAttribute():string
    {
        return $this->product->main_image_url;
    }
}
