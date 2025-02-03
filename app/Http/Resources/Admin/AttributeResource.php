<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AttributeResource extends JsonResource
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
          'title' => $this->title,
            'options' => $this->options()->get()->map(function ($item) {
                return [
                    'id' => $item->id,
                    'title' => $item->title
                ];
            })->toArray()
        ];
    }
}
