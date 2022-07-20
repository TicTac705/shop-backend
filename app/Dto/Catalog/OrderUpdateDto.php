<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDto;
use App\Http\Requests\Catalog\OrderUpdateRequest;

class OrderUpdateDto extends BaseDto
{
    public ?string $userName;
    public ?string $userEmail;
    public ?int $deliveryId;
    public ?string $deliveryAddress;
    public ?int $orderStatusId;
    public ?int $paymentStatusId;

    static function fromRequest(OrderUpdateRequest $request): self
    {
        return new self([
            'userName' => $request->get('user_name'),
            'userEmail' => $request->get('user_email'),
            'deliveryId' => intval($request->get('delivery_id')),
            'deliveryAddress' => $request->get('delivery_address'),
            'orderStatusId' => intval($request->get('order_status_id')),
            'paymentStatusId' => intval($request->get('payment_status_id'))
        ]);
    }
}
