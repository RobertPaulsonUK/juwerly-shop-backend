<?php

    namespace App\Discounts;

    use Illuminate\Support\Collection;

    interface DiscountInterface
    {
        public function apply():void;

        public function getActiveDiscounts():Collection;
    }
