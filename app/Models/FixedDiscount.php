<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use function PHPUnit\Framework\isEmpty;

class FixedDiscount extends Model
{
    protected $table = 'fixed_discounts';
    protected $fillable = [
        'title',
        'description',
        'image_url',
        'start',
        'end',
        'discount',
        'category_ids',
        'product_ids',
        'is_active'
    ];

    protected $casts = [
        'category_ids' => 'array',
        'product_ids' => 'array'
    ];

    protected function getDiscountedProductIds():array
    {
        $productIds = [];

        if(!isEmpty($this->category_ids)) {
            foreach ($this->category_ids as $categoryId) {
                $productIds[] = ProductCategory::first(['id' => $categoryId])
                                               ->products()
                                               ->pluck('id')
                                               ->toArray();
            }
        } else {
            $productIds = $this->product_ids;
        }

        return array_unique($productIds);
    }
}
