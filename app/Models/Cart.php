<?php

namespace App\Models;

use App\Service\CartService;
use App\Service\DiscountService;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Cart extends Model
{
    protected $table = 'carts';
    protected $fillable = [
      'guest_token',
      'user_id',
       'total_price',
       'discount_price',
       'total_items',
      'last_updated_at'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->last_updated_at = Carbon::now();
        });
    }

    public function User():BelongsTo
    {
        return $this->belongsTo(User::class,'user_id','id');
    }

    public function cartItems():HasMany
    {
        return $this->hasMany(CartItem::class,'cart_id','id');
    }

    public function gifts():BelongsToMany
    {
        return $this->belongsToMany(Product::class,'cart_gifts','cart_id','product_id');
    }

    public static function createGuestCart()
    {
        return self::create([
            'guest_token' => (string) Str::uuid()
        ]);
    }

    public function checkCartItemsAvailability()
    {
        $unAvailableIds = [];
        $cartItems = $this->cartItems;

        foreach ($cartItems as $cartItem) {
            if($cartItem->product->in_stock === false) {
                $unAvailableIds[] = $cartItem->id;
            }
        }

        if(!empty($unAvailableIds)) {
            $this->cartItems()->whereIn('id', $unAvailableIds)->delete();
        }

        return $this->cartItems();
    }

    public function updateCartPrice()
    {
        CartService::updateCartTotalPrice($this);
        DiscountService::applyDiscounts($this);
    }
}
