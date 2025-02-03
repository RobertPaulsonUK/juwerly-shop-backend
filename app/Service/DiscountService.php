<?php

    namespace App\Service;

    use App\Discounts\FixedDiscount;
    use App\Discounts\GiftDiscount;
    use App\Discounts\OnePlusOneDiscount;
    use App\Discounts\PercentageDiscount;
    use App\Models\Cart;

    class DiscountService
    {
        public static function applyDiscounts(Cart $cart)
        {
            $discounts = [
                new GiftDiscount($cart),
                new FixedDiscount($cart),
                new OnePlusOneDiscount($cart),
                new PercentageDiscount($cart),
            ];
            $cart->update(['discount_price' => $cart->total_price]);
            foreach ($discounts as $discount) {
                $discount->apply();
            }
        }
    }
