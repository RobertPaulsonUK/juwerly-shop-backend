<?php

namespace App\Http\Resources\Admin;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class MenuResource extends JsonResource
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
            'items' => $this->menuItems()
                            ->with(['children' => function ($query) {
                                $query->orderBy('sort');
                            }])
                            ->whereNull('parent_id')
                            ->orderBy('sort')
                            ->get()
                            ->map(function ($item) {
                                return [
                                    'id' => $item->id,
                                    'title' => $item->title,
                                    'url' => $item->url,
                                    'sort' => $item->sort,
                                    'children' => $item->children->map(function ($child) {
                                        return [
                                            'id' => $child->id,
                                            'title' => $child->title,
                                            'url' => $child->url,
                                            'sort' => $child->sort,
                                        ];
                                    }),
                                ];
                            })->toArray(),
        ];
    }

}
