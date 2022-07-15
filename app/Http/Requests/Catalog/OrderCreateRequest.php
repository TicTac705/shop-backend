<?php

namespace App\Http\Requests\Catalog;

use Illuminate\Foundation\Http\FormRequest;

class OrderCreateRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'basket_id' => ['required', 'integer', 'exists:App\Models\Catalog\Basket,id'],
            'delivery_id' => ['required', 'integer'],
            'delivery_address' => ['string']
        ];
    }
}
