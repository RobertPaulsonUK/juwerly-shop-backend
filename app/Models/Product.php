<?php

    namespace App\Models;

    use App\Traits\HasSlug;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\BelongsToMany;
    use Illuminate\Database\Eloquent\Relations\HasMany;

    class Product extends Model
    {
        use HasSlug;
        protected $table = 'products';
        protected $fillable = [
            'name',
            'article_number',
            'slug',
            'main_image_url',
            'gallery_urls',
            'content',
            'price',
            'sale_price',
            'is_hit',
            'sale_counts',
            'is_published',
            'rating',
            'category_id'
        ];
        protected $casts = [
            'gallery_urls' => 'array'
        ];

        /**
         * @return BelongsTo
         */
        public function productCategory():BelongsTo
        {
            return $this->belongsTo(ProductCategory::class,'category_id','id');
        }

        /**
         * @return BelongsToMany
         */
        public function options():BelongsToMany
        {
            return $this->belongsToMany(AttributeOption::class,
                'product_options',
                'product_id',
                'attribute_id');
        }

        /**
         * @return BelongsToMany
         */
        public function relatedProducts():BelongsToMany
        {
            return $this->belongsToMany(
                Product::class,
                'related_products',
                'first_product',
                'second_product'
            );
        }

        /**
         * @return BelongsToMany
         */
        public function crossells():BelongsToMany
        {
            return $this->belongsToMany(
                Product::class,
                'crossells',
                'main_product',
                'crossell'
            );
        }

        /**
         * @return HasMany
         */
        public function reviews():HasMany
        {
            return $this->hasMany(Review::class);
        }

        /**
         * @return BelongsToMany
         */
        public function usersLiked():BelongsToMany
        {
            return $this->belongsToMany(
                User::class,
                'product_user_likes',
                'product_id',
                'user_id'
            );
        }
    }
