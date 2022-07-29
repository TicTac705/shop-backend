<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDto;
use App\Http\Requests\Catalog\BasketItemAddingRequest;

class ProductAddedToBasketDto extends BaseDto
{
    public string $productId;

    public static function fromRequest(BasketItemAddingRequest $request): self
    {
        return new self([
            'productId' => $request->get('product_id')
        ]);
    }
}
