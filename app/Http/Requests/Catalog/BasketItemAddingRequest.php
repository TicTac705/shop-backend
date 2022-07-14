<?php

namespace App\Http\Requests\Catalog;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class BasketItemAddingRequest extends FormRequest
{
    use ApiFormRequest;

    protected $stopOnFirstFailure = true;

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'product_id' => ['required', 'integer', 'exists:App\Models\Catalog\Product,id'],
            'quantity' => ['required', 'integer', 'gt:0']
        ];
    }
}
