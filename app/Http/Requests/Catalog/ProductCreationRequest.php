<?php

namespace App\Http\Requests\Catalog;

use App\Http\Requests\ApiFormRequest;
use App\Rules\ExistsUuid;
use App\Rules\UuidValidation;
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
            'is_active' => ['required', 'boolean'],
            'name' => ['required', 'string', 'max:255', 'unique:catalog_products'],
            'description' => ['required', 'string'],
            'price' => ['required', 'numeric', 'gt:0'],
            'unit_measure_id' => ['required', new UuidValidation(), new ExistsUuid('unit_measure')],
            'store' => ['required', 'integer', 'gt:0', 'lte:10000'],
            'imagesId' => ['array'],
            'imagesId.*' => [new UuidValidation(), 'distinct', new ExistsUuid('images')],
            'categories' => ['required', 'array'],
            'categories.*' => ['required', new UuidValidation(), 'distinct', new ExistsUuid('catalog_categories')]
        ];
    }
}
