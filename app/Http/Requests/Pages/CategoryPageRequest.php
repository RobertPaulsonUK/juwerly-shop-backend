<?php

namespace App\Http\Requests\Pages;

use Illuminate\Foundation\Http\FormRequest;

class CategoryPageRequest extends FormRequest
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
            'name' => ['string'],
            'price' => ['nullable', 'array'],
            'price.min' => ['integer'],
            'price.max' => ['integer'],
            'options' => ['array','nullable'],
            'options*' => ['integer'],
            'order' => ['string'],
            'orderBy' => ['string']
        ];
    }
}
