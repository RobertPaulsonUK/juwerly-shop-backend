<?php

    namespace App\Models;

    use App\Traits\HasSlug;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\HasMany;

    class ProductCategory extends Model
    {
        use HasSlug;
        protected $fillable = [
            'name',
            'slug',
            'description'
        ];
        protected $table = 'product_categories';

        public function products():HasMany
        {
            return $this->hasMany(Product::class,'category_id','id');
        }
    }
