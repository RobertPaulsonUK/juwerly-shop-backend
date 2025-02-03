<?php

    namespace App\Http\Resources\Admin;

    use Illuminate\Http\Request;
    use Illuminate\Http\Resources\Json\JsonResource;

    class ProductCollectionResource extends JsonResource
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
                'slug' => $this->slug,
                'url' => $this->url,
                'mainImageUrl' => $this->main_image_url,
                'price' => $this->price,
                'salePrice' => $this->sale_price,
                'category' => $this->productCategory->name,
            ];
        }
    }
