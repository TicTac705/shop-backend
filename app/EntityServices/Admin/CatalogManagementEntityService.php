<?php

namespace App\EntityServices\Admin;

use App\Dto\Catalog\ProductAddFormDto;
use App\Dto\Catalog\ProductDto;
use App\Helpers\Statuses\HTTPResponseStatuses;
use App\Http\Requests\Catalog\AdditionProductRequest;
use App\Services\Catalog\CategoryService;
use App\Services\Catalog\ProductService;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;

class CatalogManagementEntityService
{
    public function store(AdditionProductRequest $request): JsonResponse
    {
        $uploadedImageIds = [];
        if ($request->hasFile('pictures')) {
            $uploadedImageIds = ImageService::saveMany('catalog_img', $request->file('pictures'));
        }

        $productFormDto = ProductAddFormDto::fromRequest($request);

        $newProduct = ProductDto::fromModel(ProductService::save($productFormDto));

        if (count($uploadedImageIds) > 0) {
            ImageService::saveManyRelationshipToProduct($uploadedImageIds, $newProduct->id);
        }

        if (count($productFormDto->categories) > 0) {
            CategoryService::saveManyRelationshipToProduct($productFormDto->categories, $newProduct->id);
        }

        return response()->json(
            [
                'data' => $newProduct->toArray()
            ],
            HTTPResponseStatuses::CREATED
        );
    }
}
