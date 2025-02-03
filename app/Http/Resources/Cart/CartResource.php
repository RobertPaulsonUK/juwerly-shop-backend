<?php

namespace App\Http\Resources\Cart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'itemsCount' => $this->total_items,
            'totalPrice' => $this->total_price,
            'discountPrice' => $this->discount_price,
            'guestToken' => $this->guest_token,
            'items' => CartItemResource::collection($this->cartItems),
            'gifts' => CartGiftResource::collection($this->gifts)
        ];
    }
}
