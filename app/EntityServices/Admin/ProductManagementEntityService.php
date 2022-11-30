<?php

namespace App\EntityServices\Admin;

use App\Dto\Catalog\CategoryLightDto;
use App\Dto\Catalog\ProductCreateDto;
use App\Dto\Catalog\ProductCreationFormDto;
use App\Dto\Catalog\ProductDestroyDto;
use App\Dto\Catalog\ProductDto;
use App\Dto\Catalog\ProductEditFormDto;
use App\Dto\Catalog\ProductUpdateDto;
use App\Dto\UnitMeasureLightDto;
use App\Exceptions\AppException;
use App\Exceptions\Catalog\UnableToDestroyProductsException;
use App\Models\Catalog\Order;
use App\PivotModels\Catalog\OrderProduct;
use App\Services\Catalog\CategoryService;
use App\Services\Catalog\OrderService;
use App\Services\Catalog\ProductService;
use App\Services\UnitMeasureService;

class ProductManagementEntityService
{
    private UnitMeasureService $unitMeasureService;
    private CategoryService $categoryService;
    private ProductService $productService;
    private OrderService $orderService;

    public function __construct(
        UnitMeasureService $unitMeasureService,
        CategoryService    $categoryService,
        ProductService     $productService,
        OrderService       $orderService
    )
    {
        $this->unitMeasureService = $unitMeasureService;
        $this->categoryService = $categoryService;
        $this->productService = $productService;
        $this->orderService = $orderService;
    }

    public function getCreateData(): ProductCreationFormDto
    {
        $unitsMeasure = $this->unitMeasureService->getAll();
        $categories = $this->categoryService->getAll();

        $unitsMeasureDtoList = UnitMeasureLightDto::fromList($unitsMeasure);
        $categoriesDtoList = CategoryLightDto::fromList($categories);

        return ProductCreationFormDto::fromDto($unitsMeasureDtoList, $categoriesDtoList);
    }

    /**
     * @throws AppException
     */
    public function store(ProductCreateDto $dto): ProductDto
    {
        $newProduct = $this->productService->save($dto);

        return ProductDto::fromModel($newProduct);
    }

    /**
     * @throws AppException
     */
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

    /**
     * @throws AppException
     */
    public function update(string $id, ProductUpdateDto $dto): ProductDto
    {
        $product = $this->productService->getById($id);

        $changedProduct = $this->productService->update($product, $dto);

        return ProductDto::fromModel($changedProduct);
    }

    /**
     * @throws AppException
     * @throws UnableToDestroyProductsException
     */
    public function destroy(string $id): void
    {
        $cannotRemovedId = $this->orderService->getCannotRemovedPositions([$id]);

        if (count($cannotRemovedId) > 0) {
            throw new UnableToDestroyProductsException('Product involved in orders', $cannotRemovedId);
        }

        $product = $this->productService->getById($id);

        $this->productService->destroy($product);
    }

    /**
     * @throws UnableToDestroyProductsException
     */
    public function destroyMany(ProductDestroyDto $dto)
    {
        $productIds = $dto->productIds;

        $cannotRemovedIds = $this->orderService->getCannotRemovedPositions($productIds);

        if (count($cannotRemovedIds) > 0) {
            throw new UnableToDestroyProductsException('Products involved in orders', $cannotRemovedIds);
        }

        $this->productService->destroyByIds($productIds);
    }
}
