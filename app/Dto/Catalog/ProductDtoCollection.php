<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDtoCollection;
use App\Models\Catalog\Product;

class ProductDtoCollection extends BaseDtoCollection
{
    /**
     * @param Product[] $data
     */
    public function __construct(array $data)
    {
        $collection = array_map(fn(Product $item):ProductDto => ProductDto::fromModel($item), $data);

        parent::__construct($collection);
    }
}
