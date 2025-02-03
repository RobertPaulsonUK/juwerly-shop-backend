<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Database\Eloquent\Relations\BelongsTo;

    class Review extends Model
    {
        protected $table = 'reviews';
        protected $fillable = [
            'rating',
            'content',
            'images_urls',
            'product_id',
            'user_id'
        ];
        protected $casts = [
            'images_urls' => 'array'
        ];

        /**
         * @return BelongsTo
         */
        public function user():BelongsTo
        {
            return $this->belongsTo(User::class);
        }

        public function product():BelongsTo
        {
            return $this->belongsTo(Product::class);
        }

    }
