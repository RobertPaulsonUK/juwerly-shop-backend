<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AttributeOption extends Model
{
    use HasFactory;
    protected $table = 'attribute_options';
    protected $fillable = [
        'title',
        'attribute_id'
    ];

    /**
     * @return BelongsToMany
     */
    public function products():BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'product_options',
            'attribute_id',
            'product_id'
        );
    }

    public function productAttributes():BelongsToMany
    {
        return $this->belongsToMany(
            Product::class,
            'product_options',
            'attribute_id',
            'product_id'
        );
    }


    /**
     * @return BelongsTo
     */
    public function attribute():BelongsTo
    {
        return $this->belongsTo(Attribute::class,'attribute_id','id');
    }
}
