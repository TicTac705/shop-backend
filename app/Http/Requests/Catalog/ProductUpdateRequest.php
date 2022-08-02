<?php

namespace App\Http\Requests\Catalog;

use App\Http\Requests\ApiFormRequest;
use App\Rules\ExistsUuid;
use App\Rules\UuidValidation;
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
            'unit_measure_id' => [new UuidValidation(), new ExistsUuid('unit_measure')],
            'store' => ['integer', 'gt:0', 'lte:10000'],
            'imagesId' => ['array'],
            'imagesId.*' => [new UuidValidation(), 'distinct', new ExistsUuid('images')],
            'categories' => ['required', 'array'],
            'categories.*' => ['required', new UuidValidation(), 'distinct', new ExistsUuid('catalog_categories')]
        ];
    }
}
