<?php

    namespace App\Discounts;

    use App\Models\Cart;
    use App\Models\CartItem;
    use App\Models\OnePlusOneDiscount as OnePlusOneDiscountAlias;
    use Illuminate\Support\Collection;

    class OnePlusOneDiscount implements DiscountInterface
    {
        protected Cart $cart;
        protected array $cartItems;
        protected Collection $activeDiscounts;

        public function __construct(Cart $cart)
        {
            $this->cart = $cart;
            $this->cartItems = $cart->cartItems()->pluck('product_id')->toArray();
            $this->activeDiscounts = $this->getActiveDiscounts();
        }

        public function apply(): void
        {
            if (empty($this->activeDiscounts)) {
                return;
            }
            $discountPrice = $this->cart->discount_price;
            foreach ($this->activeDiscounts as $activeDiscount) {
                if(in_array($activeDiscount->product_id,$this->cartItems)) {
                    $discountPrice -= $this->getProductDiscount($activeDiscount->product_id);
                }
            }
            $this->cart->update(['discount_price' => $discountPrice]);
        }
        public function getActiveDiscounts(): Collection
        {
            return OnePlusOneDiscountAlias::where('is_active', true)
                                          ->where('start', '<=', now())
                                          ->where('end', '>=', now())
                                          ->get();
        }

        public function getProductDiscount(int $productId):float
        {
            $cartItem = CartItem::where(
                ['cart_id' => $this->cart->id,
                 'product_id' => $productId]
            )->first();
            $quantity = $cartItem->quntity;
            $productPrice = $cartItem->price;
            if($quantity === 1) {
                return 0;
            }

            return $quantity % 2 === 0 ?
                $productPrice * ($quantity / 2) :
                $productPrice * (($quantity - 1) / 2);
        }
    }
