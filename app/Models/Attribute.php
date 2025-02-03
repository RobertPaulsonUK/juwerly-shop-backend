<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Attribute extends Model
{
    use HasFactory;
    protected $fillable = ['title'];
    protected $table = 'attributes';

    public function options():HasMany
    {
        return $this->hasMany(AttributeOption::class,'attribute_id','id');
    }

    public function productOptions()
    {
        return $this->belongsToMany(AttributeOption::class,
            'product_options',
            'attribute_id',
            'option_id'
        );
    }

    public function products()
    {
        return $this->belongsToMany(Product::class,
            'product_options',
            'attribute_id',
            'product_id'
        );
    }
}
