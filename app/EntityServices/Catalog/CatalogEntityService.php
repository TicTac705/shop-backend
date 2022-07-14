<?php

namespace App\EntityServices\Catalog;

use App\Dto\Catalog\ProductDto;
use App\Dto\PaginationDto;
use App\Services\Catalog\ProductService;

class CatalogEntityService
{
    public function getList(): PaginationDto
    {
        $products = ProductService::getListWithPagination(10);

        return PaginationDto::fromResultService($products, ProductDto::fromList($products->items()));
    }
}
