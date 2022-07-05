<?php

namespace App\Http\Requests\Catalog;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class AdditionProductRequest extends FormRequest
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
            'pictures.*' => ['image', 'max:5120'],
            'categories.*' => ['required', 'integer', 'exists:App\Models\Catalog\Category,id']
        ];
    }
}
