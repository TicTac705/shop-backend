<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDto;
use App\Http\Requests\Catalog\BasketItemAddingRequest;

class ProductAddedToCartDto extends BaseDto
{
    public int $productId;
    public int $quantity;

    public static function fromRequest(BasketItemAddingRequest $request): self
    {
        return new self([
            'productId' => intval($request->get('product_id')),
            'quantity' => intval($request->get('quantity'))
        ]);
    }
}
