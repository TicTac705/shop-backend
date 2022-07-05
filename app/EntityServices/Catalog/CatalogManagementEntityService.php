<?php

namespace App\EntityServices\Catalog;

use App\Dto\Catalog\ProductAddFormDto;
use App\Dto\Catalog\ProductDto;
use App\Helpers\Statuses\HTTPResponseStatuses;
use App\Http\Requests\Catalog\AdditionProductRequest;
use App\Models\Catalog\Product;
use App\Services\Catalog\CategoryService;
use App\Services\Catalog\ProductService;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;

class CatalogManagementEntityService
{
    public function store(AdditionProductRequest $request)
    {
        $uploadedImageIds = [];
        if ($request->hasFile('pictures')) {
            $uploadedImageIds = ImageService::saveMany('catalog_img', $request->file('pictures'));
        }

        $productFormDto = ProductAddFormDto::fromRequest($request);

        $newProduct = new ProductDto(ProductService::save($productFormDto)->toArray());

        if (count($uploadedImageIds) > 0) {
            ImageService::saveManyRelationship($uploadedImageIds, $newProduct->id);
        }

        if (count($productFormDto->categories) > 0) {
            CategoryService::saveManyRelationship($productFormDto->categories, $newProduct->id);
        }

        return response()->json(
            [
                'data' => $newProduct->toArray()
            ],
            HTTPResponseStatuses::CREATED
        );
    }
}
