<?php

namespace App\EntityServices\Admin;

use App\Dto\Catalog\ProductCreateDto;
use App\Dto\Catalog\ProductDto;
use App\Helpers\Statuses\HTTPResponseStatuses;
use App\Http\Requests\Catalog\ProductCreationRequest;
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
            ImageService::saveManyRelationshipToProduct($uploadedImageIds, $newProduct->getId());
        }

        if (count($productFormDto->categories) > 0) {
            CategoryService::saveManyRelationshipToProduct($productFormDto->categories, $newProduct->getId());
        }

        return response()->json(
            [
                'data' => ProductDto::fromModel($newProduct)->toArray()
            ],
            HTTPResponseStatuses::CREATED
        );
    }
}
