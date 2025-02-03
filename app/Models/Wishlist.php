<?php

    namespace App\Models;

    use Illuminate\Database\Eloquent\Model;
    use Illuminate\Support\Facades\Auth;

    class Wishlist extends Model
    {
        protected $table = 'wishlists';

        protected $fillable = [
            'product_id',
            'user_id'
        ];


        public static function add(int $product_id):self | null
        {
            return self::firstOrCreate([
                'product_id' => $product_id,
                'user_id' => Auth::id()
            ]);
        }

        public static function isInWishlist(int $product_id)
        {
            return self::where('product_id', $product_id)
                       ->where('user_id', Auth::id())
                       ->exists();
        }

        public static function remove(int $product_id):bool
        {
            $item = self::where('product_id', $product_id)
                        ->where('user_id', Auth::id());
            if(!$item) {
                return false;
            }
            $item->delete();
            return true;
        }


        public function product()
        {
            return $this->belongsTo(Product::class);
        }

        public function user()
        {
            return $this->belongsTo(User::class);
        }
    }
