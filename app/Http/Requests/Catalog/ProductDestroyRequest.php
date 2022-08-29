<?php

namespace App\Http\Requests\Catalog;

use App\Rules\ExistsUuid;
use App\Rules\UuidValidation;
use Illuminate\Foundation\Http\FormRequest;

class ProductDestroyRequest extends FormRequest
{
    protected $stopOnFirstFailure = true;

    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'productIds' => ['bail', 'required', 'array'],
            'productIds.*' => ['bail', new UuidValidation(), 'distinct', new ExistsUuid('catalog_products')],
        ];
    }
}
