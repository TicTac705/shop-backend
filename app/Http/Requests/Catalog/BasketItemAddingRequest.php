<?php

namespace App\Http\Requests\Catalog;

use App\Http\Requests\ApiFormRequest;
use App\Rules\ExistsUuid;
use App\Rules\UuidValidation;
use Illuminate\Foundation\Http\FormRequest;

class BasketItemAddingRequest extends FormRequest
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
            'product_id' => ['bail', 'required', new UuidValidation(), new ExistsUuid('catalog_products')]
        ];
    }
}
