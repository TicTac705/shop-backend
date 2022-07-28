<?php

namespace App\Http\Requests\Catalog;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class ProductUpdateRequest extends FormRequest
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
            'is_active' => ['boolean'],
            'name' => ['string', 'max:255', 'unique:catalog_products'],
            'description' => ['string'],
            'price' => ['numeric', 'gt:0'],
            'unit_measure_id' => ['string', 'exists:App\Models\UnitMeasure,_id'],
            'store' => ['integer', 'gt:0', 'lte:10000'],
            'imagesId' => ['array'],
            'imagesId.*' => ['string', 'exists:App\Models\Image,_id', 'distinct'],
            'categories' => ['required', 'array'],
            'categories.*' => ['required', 'string', 'exists:App\Models\Catalog\Category,_id', 'distinct']
        ];
    }
}
