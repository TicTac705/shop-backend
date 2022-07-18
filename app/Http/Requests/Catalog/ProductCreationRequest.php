<?php

namespace App\Http\Requests\Catalog;

use App\Http\Requests\ApiFormRequest;
use App\PivotModels\Catalog\ProductImage;
use App\Rules\NotExistsInDataBase;
use Illuminate\Foundation\Http\FormRequest;

class ProductCreationRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255', 'unique:catalog_products'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'gt:0'],
            'unit_measure_id' => ['required', 'integer', 'exists:App\Models\UnitMeasure,id'],
            'store' => ['required', 'integer', 'gt:0', 'lte:10000'],
            'imagesId' => ['array'],
            'imagesId.*' => ['integer', 'exists:App\Models\Image,id', 'distinct', new NotExistsInDataBase(new ProductImage(), 'image_id')],
            'categories' => ['required', 'array'],
            'categories.*' => ['required', 'integer', 'exists:App\Models\Catalog\Category,id', 'distinct']
        ];
    }
}
