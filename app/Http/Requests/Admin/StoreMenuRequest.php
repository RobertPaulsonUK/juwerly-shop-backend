<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class StoreMenuRequest extends FormRequest
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
            'title' => ['required','string','unique:menus,title'],
            'items' => ['nullable','array'],
            'items.*.title' => ['string'],
            'items.*.url' => ['string'],
            'items.*.sort' => ['int'],
            'items.*.children' => ['nullable','array'],
            'items.*.children.*.title' => ['string'],
            'items.*.children.*.url' => ['string'],
            'items.*.children.*.sort' => ['int'],
        ];
    }
}
