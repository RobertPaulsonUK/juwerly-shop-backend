<?php

namespace App\Http\Resources\Admin;

use App\Http\Resources\VariationResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'articleNumber' => $this->article_number,
            'mainImageUrl' => $this->main_image_url,
            'galleryUrls' => $this->gallery_urls,
            'content' => $this->content,
            'price' => $this->price,
            'salePrice' => $this->sale_price,
            'inStock' => $this->in_stock,
            'isHit' => $this->is_hit,
            'isPublished' => $this->is_published,
            'category' => $this->productCategory->name,
            'attributes' => $this->getAttributesWithOptionsToArray(),
            'reviews' => $this->reviews()
                              ->get()
                              ->map(function ($item){
                                return [
                                    'id' => $item->id,
                                    'rating' => $item->rating,
                                    'user' => $item->user()->name
                                ];
                            })->toArray(),
            'relatedProducts' => $this->hasRelatedProducts()
                                      ->get()
                                      ->map(function ($item) {
                                return $item->getPreviewData();
                            })->toArray(),
            'crossells' => $this->hasCrossells()
                                ->get()
                                ->map(function ($item) {
                                return $item->getPreviewData();
                            })->toArray(),
            'variations' => VariationResource::collection($this->variations)
        ];
    }
}
