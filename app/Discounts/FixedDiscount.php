<?php

    namespace App\Discounts;

    use App\Models\Cart;
    use App\Models\CartItem;
    use App\Models\FixedDiscount as FixedDiscountAlias;
    use Illuminate\Support\Collection;

    class FixedDiscount implements DiscountInterface
    {
        protected Cart $cart;
        protected Collection $activeDiscounts;
        protected array $cartItems;

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
                $product_ids = $activeDiscount->getDiscountedProductIds();
                $discountPrice -= $this->calcCartItemDiscount($product_ids,$activeDiscount);
            }

            $this->cart->update(['discount_price' => $discountPrice]);
        }

        public function getActiveDiscounts(): Collection
        {
            return FixedDiscountAlias::where('is_active', true)
                                     ->where('start', '<=', now())
                                     ->where('end', '>=', now())
                                     ->get();
        }

        public function calcCartItemDiscount(array $discountedProductIds, FixedDiscountAlias $activeDiscount):float
        {
            $discount = 0;
              foreach ($this->cartItems as $cartItem)
              {
                  if(in_array($cartItem,$discountedProductIds)) {
                      $discount += $activeDiscount->discount;
                  }
              }

              return $discount;
        }
    }
