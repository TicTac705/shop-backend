<?php

namespace App\EntityServices\Admin;

use App\Dto\Catalog\CategoryLightDto;
use App\Dto\Catalog\ProductCreateDto;
use App\Dto\Catalog\ProductDto;
use App\Dto\Catalog\ProductUpdateDto;
use App\Dto\ResponseData;
use App\Dto\UnitMeasureLightDto;
use App\Helpers\Statuses\HTTPResponseStatuses;
use App\Http\Requests\Catalog\ProductCreationRequest;
use App\Http\Requests\Catalog\ProductUpdateRequest;
use App\Services\Catalog\CategoryService;
use App\Services\Catalog\ProductService;
use App\Services\ImageService;
use App\Services\UnitMeasureService;

class ProductManagementEntityService
{
    //создать конструктор с сервисами

    public function getCreateData(): ResponseData
    {
        $unitsMeasure = UnitMeasureService::getAll();
        $categories = CategoryService::getAll();

        $unitsMeasureDtoList = UnitMeasureLightDto::fromList($unitsMeasure);
        $categoriesDtoList = CategoryLightDto::fromList($categories);

        return new ResponseData([
            'unitsMeasure' => $unitsMeasureDtoList,
            'categories' => $categoriesDtoList
        ]);
    }

    public function store(ProductCreationRequest $request): ResponseData
    {
        $uploadedImageIds = [];
        if ($request->hasFile('pictures')) {
            $uploadedImageIds = ImageService::saveMany('public/catalog_img', $request->file('pictures'));
        }

        $productFormDto = ProductCreateDto::fromRequest($request);

        $newProduct = ProductService::save($productFormDto);

        if (count($uploadedImageIds) > 0) {
            ImageService::saveManyRelationshipToProduct($uploadedImageIds, $newProduct);
        }

        if (count($productFormDto->categories) > 0) {
            CategoryService::saveManyRelationshipToProduct($productFormDto->categories, $newProduct);
        }

        return new ResponseData(
            ProductDto::fromModel($newProduct),
            HTTPResponseStatuses::CREATED
        );
    }

    public function getUpdateData(int $id): ResponseData
    {
        $product = ProductService::getById($id);

        $unitsMeasure = UnitMeasureService::getAll();
        $categories = CategoryService::getAll();

        $productDto = ProductDto::fromModel($product);
        $unitsMeasureDtoList = UnitMeasureLightDto::fromList($unitsMeasure);
        $categoriesDtoList = CategoryLightDto::fromList($categories);

        return new ResponseData([
            'product' => $productDto,
            'unitsMeasure' => $unitsMeasureDtoList,
            'categories' => $categoriesDtoList
        ]);
    }

    public function update(ProductUpdateRequest $request, int $id): ResponseData
    {
        $product = ProductService::getById($id);

        $uploadedImageIds = [];
        if ($request->hasFile('pictures')) {
            $uploadedImageIds = ImageService::saveMany('public/catalog_img', $request->file('pictures'));
        }

        $productFormDto = ProductUpdateDto::fromRequest($request);//вынести в контроллер

        $changedProduct = ProductService::update($product, $productFormDto);

        if (count($productFormDto->categories) > 0) {
            CategoryService::saveManyRelationshipToProduct($productFormDto->categories, $changedProduct);
        }

        if (count($uploadedImageIds) > 0) {
            ImageService::saveManyRelationshipToProduct($uploadedImageIds, $changedProduct);
        }

        return new ResponseData(ProductDto::fromModel($changedProduct));//вынести в контроллер
    }
}
