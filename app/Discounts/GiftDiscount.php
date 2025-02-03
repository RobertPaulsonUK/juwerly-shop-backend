<?php

    namespace App\Discounts;

    use App\Models\Cart;
    use App\Models\CartGift;
    use App\Models\GiftDiscount as GiftDiscountAlias;
    use Illuminate\Support\Collection;

    class GiftDiscount implements DiscountInterface
    {
        protected Cart $cart;
        protected Collection $activeDiscounts;

        public function __construct(Cart $cart)
        {
            $this->cart = $cart;
            $this->activeDiscounts = $this->getActiveDiscounts();
        }

        public function apply(): void
        {
            if (empty($this->activeDiscounts)) {
                return;
            }

            foreach ($this->activeDiscounts as $activeDiscount) {
                if ($this->cart->total_price > $activeDiscount->threshold) {
                    CartGift::firstOrCreate([
                        'cart_id' => $this->cart->id,
                        'product_id' => $activeDiscount->product_id
                    ]);
                } else {
                    CartGift::where('cart_id', $this->cart->id)
                            ->where('product_id', $activeDiscount->product_id)
                            ->delete();
                }
            }
        }



        public function getActiveDiscounts(): Collection
        {
            return GiftDiscountAlias::where('is_active', true)
                                    ->where('start', '<=', now())
                                    ->where('end', '>=', now())
                                    ->get();
        }
    }
