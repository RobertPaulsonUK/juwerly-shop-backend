<?php

    namespace App\Models;

    enum OrderStatus:string
    {
        case ON_HOLD = 'on_hold';
        case PAYMENT_COMPLETED = 'payment_completed';
        case CANCELLED = 'cancelled';
        case DELIVERY_COMPLETED = 'delivery_completed';

        public function title(): string
        {
            return match ($this->value) {
                'on_hold' => 'Order is on hold.',
                'payment_completed' => 'The order has been paid successfully.',
                'cancelled' => 'Order is cancelled.',
                'delivery_completed' => 'The goods have been delivered.',
            };
        }
    }
