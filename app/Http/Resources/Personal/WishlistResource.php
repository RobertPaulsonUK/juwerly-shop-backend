<?php

namespace App\Http\Resources\Personal;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class WishlistResource extends JsonResource
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
            'name' => $this->name,
            'url' => $this->url,
            'mainImageUrl' => $this->main_image_url,
            'price' => $this->price,
            'salePrice' => $this->sale_price,
            'isHit' => $this->is_hit,
            'rating' => $this->rating,
            'inStock' => $this->in_stock
        ];
    }
}
