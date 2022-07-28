<?php

namespace App\EntityServices\Admin;

use App\Dto\Catalog\CategoryLightDto;
use App\Dto\Catalog\ProductCreateDto;
use App\Dto\Catalog\ProductCreationFormDto;
use App\Dto\Catalog\ProductDto;
use App\Dto\Catalog\ProductEditFormDto;
use App\Dto\Catalog\ProductUpdateDto;
use App\Dto\UnitMeasureLightDto;
use App\Services\Catalog\CategoryService;
use App\Services\Catalog\ProductService;
use App\Services\ImageService;
use App\Services\UnitMeasureService;

class ProductManagementEntityService
{
    private UnitMeasureService $unitMeasureService;
    private CategoryService $categoryService;
    private ImageService $imageService;
    private ProductService $productService;

    public function __construct(
        UnitMeasureService $unitMeasureService,
        CategoryService    $categoryService,
        ImageService       $imageService,
        ProductService     $productService
    )
    {
        $this->unitMeasureService = $unitMeasureService;
        $this->categoryService = $categoryService;
        $this->imageService = $imageService;
        $this->productService = $productService;
    }

    public function getCreateData(): ProductCreationFormDto
    {
        $unitsMeasure = $this->unitMeasureService->getAll();
        $categories = $this->categoryService->getAll();

        $unitsMeasureDtoList = UnitMeasureLightDto::fromList($unitsMeasure);
        $categoriesDtoList = CategoryLightDto::fromList($categories);

        return ProductCreationFormDto::fromDto($unitsMeasureDtoList, $categoriesDtoList);
    }

    public function store(ProductCreateDto $dto): ProductDto
    {
        $newProduct = $this->productService->save($dto);

        return ProductDto::fromModel($newProduct);
    }

    public function getUpdateData(string $id): ProductEditFormDto
    {
        $product = $this->productService->getById($id);

        $unitsMeasure = $this->unitMeasureService->getAll();
        $categories = $this->categoryService->getAll();

        $productDto = ProductDto::fromModel($product);
        $unitsMeasureDtoList = UnitMeasureLightDto::fromList($unitsMeasure);
        $categoriesDtoList = CategoryLightDto::fromList($categories);

        return ProductEditFormDto::fromDto($productDto, $unitsMeasureDtoList, $categoriesDtoList);
    }

    public function update(string $id, ProductUpdateDto $dto): ProductDto
    {
        $product = $this->productService->getById($id);

        $changedProduct = $this->productService->update($product, $dto);

        return ProductDto::fromModel($changedProduct);
    }

    public function destroy(string $id): void
    {
        $product = $this->productService->getById($id);

        $this->productService->destroy($product);
    }
}
