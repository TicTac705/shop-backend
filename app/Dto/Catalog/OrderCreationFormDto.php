<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDto;
use App\Http\Requests\Catalog\OrderCreateRequest;

class OrderCreationFormDto extends BaseDto
{
    public int $basketId;
    public int $deliveryId;
    public string $deliveryAddress;

    static function fromRequest(OrderCreateRequest $request): self
    {
        return new self([
            'basketId' => $request->get('basket_id'),
            'deliveryId' => $request->get('delivery_id'),
            'deliveryAddress' => $request->get('delivery_address')
        ]);
    }
}
