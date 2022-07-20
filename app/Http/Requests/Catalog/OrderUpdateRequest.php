<?php

namespace App\Http\Requests\Catalog;

use App\Helpers\Statuses\Order\DeliveryStatuses;
use App\Http\Requests\ApiFormRequest;
use App\Rules\ExistsOrderStatus;
use App\Rules\ExistsPaymentStatus;
use Illuminate\Foundation\Http\FormRequest;

class OrderUpdateRequest extends FormRequest
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
            'user_name' => ['string', 'max:255'],
            'user_email' => ['string', 'email', 'max:255'],
            'delivery_id' => ['integer', new ExistsPaymentStatus],
            'delivery_address' => ['required_if:delivery_id,' . DeliveryStatuses::COURIER_DELIVERY, 'string'],
            'order_status_id' => ['integer', new ExistsOrderStatus],
            'payment_status_id' => ['integer', new ExistsPaymentStatus]
        ];
    }
}
