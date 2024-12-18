<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class AttributeOption extends Model
{
    protected $table = 'attribute_options';
    protected $fillable = [
        'title',
        'attribute_id'
    ];

    /**
     * @return BelongsToMany
     */
    public function Products():BelongsToMany
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
    public function Attribute():BelongsTo
    {
        return $this->belongsTo(Attribute::class,'attribute_id','id');
    }
}
