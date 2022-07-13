<?php

namespace App\EntityServices\Catalog;

use App\Dto\Catalog\ProductDto;
use App\Dto\ResponsePaginationData;
use App\Services\Catalog\ProductService;

class CatalogEntityService
{
    public function getList(): ResponsePaginationData
    {
        $products = ProductService::getListWithPagination(10);

        return new ResponsePaginationData([
            'paginator' => $products,
            'collection' => ProductDto::fromList($products->items()),
        ]);
    }
}
