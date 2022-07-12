<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDtoCollection;
use App\PivotModels\Catalog\BasketProduct;

class BasketItemDtoCollection extends BaseDtoCollection
{
    /**
     * @param BasketProduct[] $data
     */
    public function __construct(array $data)
    {
        $collection = array_map(fn(BasketProduct $item):BasketItemDto => BasketItemDto::fromModel($item), $data);

        parent::__construct($collection);
    }
}
