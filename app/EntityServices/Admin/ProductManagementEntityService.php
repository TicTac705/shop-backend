<?php

namespace App\EntityServices\Admin;

use App\Dto\Catalog\ProductCreateDto;
use App\Dto\Catalog\ProductDto;
use App\Dto\Catalog\ProductUpdateDto;
use App\Helpers\Statuses\HTTPResponseStatuses;
use App\Http\Requests\Catalog\ProductCreationRequest;
use App\Http\Requests\Catalog\ProductUpdateRequest;
use App\Services\Catalog\CategoryService;
use App\Services\Catalog\ProductService;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;

class ProductManagementEntityService
{
    public function store(ProductCreationRequest $request): JsonResponse
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

        return response()->json(
            [
                'data' => ProductDto::fromModel($newProduct)->toArray()
            ],
            HTTPResponseStatuses::CREATED
        );
    }

    public function update(ProductUpdateRequest $request, int $id): JsonResponse
    {
        $product = ProductService::getById($id);

        $uploadedImageIds = [];
        if ($request->hasFile('pictures')) {
            $uploadedImageIds = ImageService::saveMany('public/catalog_img', $request->file('pictures'));
        }

        $productFormDto = ProductUpdateDto::fromRequest($request);

        $changedProduct = ProductService::update($product, $productFormDto);

        if (count($productFormDto->categories) > 0) {
            CategoryService::saveManyRelationshipToProduct($productFormDto->categories, $changedProduct);
        }

        if (count($uploadedImageIds) > 0) {
            ImageService::saveManyRelationshipToProduct($uploadedImageIds, $changedProduct);
        }

        return response()->json(
            [
                'data' => ProductDto::fromModel($changedProduct)->toArray()
            ],
            HTTPResponseStatuses::OK
        );
    }
}
