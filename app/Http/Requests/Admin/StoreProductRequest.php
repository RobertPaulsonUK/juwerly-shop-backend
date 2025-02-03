<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required','string','unique:products,name'],
            'article_number' => ['required','int','unique:products,article_number'],
            'main_image_url' => ['required','string'],
            'gallery_urls' => ['nullable','array'],
            'gallery_urls.*' => ['string'],
            'content' => ['string'],
            'price' => ['required','int'],
            'sale_price' => ['nullable','int','lt:price'],
            'is_hit' => ['boolean'],
            'is_published' => ['boolean'],
            'category' => ['nullable','string'],
            'attributes' => ['nullable','array'],
            'attributes.*.attribute.title' => ['required', 'string'],
            'attributes.*.options.*.title' => ['required', 'string'],
            'attributes.*.options.*.id' => ['id'],
            'relatedProducts' => ['nullable','array'],
            'relatedProducts.*' => ['int'],
            'crossels' => ['nullable','array'],
            'crossels.*' => ['int'],
            'variations' => ['nullable','array'],
            'variations.*.price' => ['required','int'],
            'variations.*.sale_price' => ['nullable','int'],
            'variations.*.in_stock' => ['boolean'],
            'variations.*.value' => ['required','array'],
            'variations.*.value.attribute' => ['required','string'],
            'variations.*.value.option' => ['required','string'],
        ];
    }
}
