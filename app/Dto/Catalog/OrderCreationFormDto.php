<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDto;
use App\Http\Requests\Catalog\OrderCreationRequest;

class OrderCreationFormDto extends BaseDto
{
    public string $basketId;
    public int $deliveryId;
    public ?string $deliveryAddress;

    static function fromRequest(OrderCreationRequest $request): self
    {
        return new self([
            'basketId' => $request->get('basket_id'),
            'deliveryId' => intval($request->get('delivery_id')),
            'deliveryAddress' => $request->get('delivery_address')
        ]);
    }
}
