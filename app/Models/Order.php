<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    protected $table = 'orders';
    protected $fillable = [
        'status',
        'billing_name',
        'billing_surname',
        'billing_phone',
        'billing_email',
        'billing_delivery_method',
        'billing_delivery_city',
        'billing_delivery_area',
        'billing_delivery_address',
        'billing_payment_method',
        'user_id',
        'notice',
        'total_price',
        'items_count'
    ];

    protected $casts = [
        'notice' => 'array'
    ];

    public function order_items():HasMany
    {
        return $this->hasMany(OrderItem::class,'order_id','id');
    }

    protected function setOrderTotalPrice():void
    {
        $orderItems = $this->order_items();
        $totalPrice = 0;
        foreach ($orderItems as $order_item) {
            $totalPrice+= $order_item->price;
        }

        $this->update(['total_price' => $totalPrice]);
    }
    protected function setOrderItemsCount():void
    {
        $orderItems = $this->order_items();
        $itemsCount = 0;
        foreach ($orderItems as $order_item) {
            $itemsCount+= $order_item->quantity;
        }

        $this->update(['items_count' => $itemsCount]);
    }

    protected function addNotice(string $message):void
    {
        $this->update(
            ['notice' => $this->notice[$message]]
        );
    }
}
