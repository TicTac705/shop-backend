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
    //создать конструктор с сервисами

    public function getCreateData(): ProductCreationFormDto
    {
        $unitsMeasure = UnitMeasureService::getAll();
        $categories = CategoryService::getAll();

        $unitsMeasureDtoList = UnitMeasureLightDto::fromList($unitsMeasure);
        $categoriesDtoList = CategoryLightDto::fromList($categories);

        return ProductCreationFormDto::fromDto($unitsMeasureDtoList, $categoriesDtoList);
    }

    public function store(ProductCreateDto $dto): ProductDto
    {
        $uploadedImageIds = [];
        if (is_array($dto->pictures) && count($dto->pictures) > 0) {
            $uploadedImageIds = ImageService::saveMany('public/catalog_img', $dto->pictures);
        }

        $newProduct = ProductService::save($dto);

        if (count($uploadedImageIds) > 0) {
            ImageService::saveManyRelationshipToProduct($uploadedImageIds, $newProduct);
        }

        if (count($dto->categories) > 0) {
            CategoryService::saveManyRelationshipToProduct($dto->categories, $newProduct);
        }

        return ProductDto::fromModel($newProduct);
    }

    public function getUpdateData(int $id): ProductEditFormDto
    {
        $product = ProductService::getById($id);

        $unitsMeasure = UnitMeasureService::getAll();
        $categories = CategoryService::getAll();

        $productDto = ProductDto::fromModel($product);
        $unitsMeasureDtoList = UnitMeasureLightDto::fromList($unitsMeasure);
        $categoriesDtoList = CategoryLightDto::fromList($categories);

        return ProductEditFormDto::fromDto($productDto, $unitsMeasureDtoList, $categoriesDtoList);
    }

    public function update(ProductUpdateDto $dto, int $id): ProductDto
    {
        $product = ProductService::getById($id);

        $uploadedImageIds = [];
        if (is_array($dto->pictures) && count($dto->pictures) > 0) {
            $uploadedImageIds = ImageService::saveMany('public/catalog_img', $dto->pictures);
        }

        $changedProduct = ProductService::update($product, $dto);

        if (count($dto->categories) > 0) {
            CategoryService::saveManyRelationshipToProduct($dto->categories, $changedProduct);
        }

        if (count($uploadedImageIds) > 0) {
            ImageService::saveManyRelationshipToProduct($uploadedImageIds, $changedProduct);
        }

        return ProductDto::fromModel($changedProduct);
    }
}
