<?php

namespace App\EntityServices\Catalog;

use App\Dto\Catalog\ProductDto;
use App\Dto\PaginationDto;
use App\Exceptions\AppException;
use App\Services\Catalog\ProductService;

class CatalogEntityService
{
    private ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    /**
     * @throws AppException
     */
    public function getList(): PaginationDto
    {
        $products = $this->productService->getListWithPagination(12);

        return PaginationDto::fromResultService($products, ProductDto::fromList($products->items()));
    }

    /**
     * @throws AppException
     */
    public function getListFromManagement(): PaginationDto
    {
        $products = $this->productService->getListWithPaginationFromManagement(20);

        return PaginationDto::fromResultService($products, ProductDto::fromList($products->items()));
    }
}
