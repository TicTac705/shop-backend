<?php

namespace App\Http\Requests\Catalog;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class BasketItemUpdatingRequest extends FormRequest
{
    use ApiFormRequest;

    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'product_id' => ['required', 'string', 'exists:App\Models\Catalog\Product,_id'],
            'quantity' => ['required', 'integer', 'gt:0']
        ];
    }
}

