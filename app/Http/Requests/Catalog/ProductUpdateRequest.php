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
            'name' => ['string', 'max:255', 'unique:catalog_products'],
            'description' => ['string'],
            'price' => ['numeric', 'gt:0'],
            'unit_measure_id' => ['integer', 'exists:App\Models\UnitMeasure,id'],
            'store' => ['integer', 'gt:0', 'lte:10000'],
            'pictures.*' => ['image', 'max:5120'],
            'categories.*' => ['required', 'integer', 'exists:App\Models\Catalog\Category,id']
        ];
    }
}
