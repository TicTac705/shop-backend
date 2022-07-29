<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDto;
use App\Http\Requests\Catalog\BasketItemUpdatingRequest;

class ProductUpdatedToBasketDto extends BaseDto
{
    public string $productId;
    public int $quantity;

    public static function fromRequest(BasketItemUpdatingRequest $request): self
    {
        return new self([
            'productId' => $request->get('product_id'),
            'quantity' => intval($request->get('quantity'))
        ]);
    }
}
