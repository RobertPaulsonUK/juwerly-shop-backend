<?php

namespace App\Http\Resources\Cart;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartGiftResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $product = $this->product;
        return [
            'name' => $product->name,
            'price' => $product->price,
            'imageUrl' => $product->main_image_url,
            'url' => $product->url,
        ];
    }
}
