<?php

namespace App\EntityServices\Catalog;

use App\Dto\Catalog\ProductDto;
use App\Dto\PaginationDto;
use App\Services\Catalog\ProductService;

class CatalogEntityService
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function getList(): PaginationDto
    {
        $products = $this->productService->getListWithPagination(10);

        return PaginationDto::fromResultService($products, ProductDto::fromList($products->items()));
    }
}
