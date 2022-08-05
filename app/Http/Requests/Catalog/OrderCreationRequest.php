<?php

namespace App\Http\Requests\Catalog;

use App\Helpers\Statuses\Order\DeliveryStatuses;
use App\Http\Requests\ApiFormRequest;
use App\Rules\ExistsDeliveryStatus;
use App\Rules\ExistsUuid;
use App\Rules\UuidValidation;
use Illuminate\Foundation\Http\FormRequest;

class OrderCreationRequest extends FormRequest
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
            'basket_id' => ['bail', 'required', new UuidValidation(), new ExistsUuid('catalog_baskets')],
            'delivery_id' => ['required', 'integer', new ExistsDeliveryStatus],
            'delivery_address' => ['required_if:delivery_id,' . DeliveryStatuses::COURIER_DELIVERY, 'string']
        ];
    }
}
