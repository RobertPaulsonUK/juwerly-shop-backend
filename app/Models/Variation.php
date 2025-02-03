<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Variation extends Model
{
    use HasFactory;
    protected $table = 'variations';
    protected $fillable = [
      'price',
      'sale_price',
      'in_stock',
      'value',
      'product_id'
    ];

    protected $casts = [
        'value' => 'array'
    ];

    public function product():BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
    public function getNameAttribute():string
    {
        return $this->product->name . ' ' . $this->value['option'];
    }
    public function getUrlAttribute():string
    {
        return $this->product->url . '?variation=' . $this->id;
    }

    public function getMainImageUrlAttribute():string
    {
        return $this->product->main_image_url;
    }

}
