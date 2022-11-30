<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDto;
use App\Http\Requests\Catalog\ProductDestroyRequest;

class ProductDestroyDto extends BaseDto
{
    /** @var string[]  */
    public array $productIds;

    static function fromRequest(ProductDestroyRequest $request): self
    {
        return new self([
            'productIds' => $request->get('productIds'),
        ]);
    }
}
