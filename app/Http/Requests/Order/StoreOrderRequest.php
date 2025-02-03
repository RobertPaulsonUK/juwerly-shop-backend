<?php

namespace App\Http\Requests\Order;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
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
            'quest_token' => ['string'],
            'billing_name' => ['string','required'],
            'billing_surname' => 'string','required',
            'billing_phone' => ['string','required'],
            'billing_email' => ['email','required'],
            'billing_delivery_city' => ['string','required'],
            'billing_delivery_area' => ['string','required'],
            'billing_delivery_address' => ['string','required'],
            'billing_delivery_method' => ['string','required'],
            'billing_payment_method' => ['string','required'],
        ];
    }
}
