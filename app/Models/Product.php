<?php

    namespace App\Models;

    use App\Traits\Filterable;
    use App\Traits\HasSlug;
    use App\Traits\HasType;
    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;
    use Illuminate\Database\Eloquent\Relations\BelongsToMany;
    use Illuminate\Database\Eloquent\Relations\HasMany;

    class Product extends Model
    {
        use HasSlug;
        use HasType;
        use HasFactory;
        use Filterable;
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
            'in_stock',
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
                'option_id'
            );
        }

        /**
         * @return BelongsToMany
         */
        public function attributes(): BelongsToMany
        {
            return $this->belongsToMany(
                Attribute::class,
                'product_options',
                'product_id',
                'attribute_id'
            );
        }

        /**
         * Get related products
         *
         * @return BelongsToMany
         */
        public function hasRelatedProducts():BelongsToMany
        {
            return $this->belongsToMany(
                Product::class,
                'related_products',
                'first_product',
                'second_product'
            );
        }

        /**
         *  Get crossels products
         *
         * @return BelongsToMany
         */
        public function hasCrossells():BelongsToMany
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

        public function variations():HasMany
        {
            return $this->hasMany(Variation::class);
        }

        public function getPreviewData():array
        {
            return [
                'id' => $this->id,
                'name' => $this->name,
                'mainImageUrl' => $this->main_image_url,
            ];
        }

        public function getAttributesWithOptionsToArray():array
        {
            $result = [];
            $attributes = $this->attributes()->get();
            foreach ($attributes as $attr)
            {
                $result[] = array(
                    'attribute' => [
                        'id' => $attr->id,
                        'title' => $attr->title
                    ],
                    'options' => $this->options()
                                      ->where('attribute_options.attribute_id','=',$attr->id)
                                      ->get()
                                      ->map(function ($option){
                                        return [
                                            'id' => $option->id,
                                            'title' => $option->title
                                        ];
                                    })->toArray()
                );
            }
            return $result;
        }

    }
