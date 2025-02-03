<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Factories\HasFactory;
    use Illuminate\Database\Eloquent\Model;

    class ProductOption extends Model
    {
        use HasFactory;
        protected $table = 'product_options';
        protected $fillable = [
            'product_id',
            'option_id',
            'attribute_id',
        ];

        public function product()
        {
            return $this->belongsTo(Product::class);
        }

        public function option()
        {
            return $this->belongsTo(AttributeOption::class, 'option_id');
        }

        public function attribute()
        {
            return $this->belongsTo(Attribute::class, 'attribute_id');
        }
    }
