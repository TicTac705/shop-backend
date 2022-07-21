<?php

namespace App\Http\Requests\Catalog;

use App\Http\Requests\ApiFormRequest;
use App\PivotModels\Catalog\ProductImage;
use App\Rules\NotExistsInDataBase;
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
            'unit_measure_id' => ['integer', 'exists:App\Models\UnitMeasure,id'],
            'store' => ['integer', 'gt:0', 'lte:10000'],
            'imagesId' => ['array'],
            'imagesId.*' => ['integer', 'exists:App\Models\Image,id', 'distinct', new NotExistsInDataBase(new ProductImage(), 'image_id')],
            'categories' => ['required', 'array'],
            'categories.*' => ['required', 'integer', 'exists:App\Models\Catalog\Category,id', 'distinct']
        ];
    }
}
