<?php

namespace App\Http\Controllers\Admin;

use App\Dto\Catalog\CategoryDtoCollection;
use App\Dto\Catalog\ProductDto;
use App\Dto\Catalog\ProductDtoCollection;
use App\Dto\Catalog\ProductUpdateDto;
use App\Dto\ResponseData;
use App\Dto\ResponsePaginationData;
use App\Dto\UnitMeasureDtoCollection;
use App\EntityServices\Admin\ProductManagementEntityService;
use App\Helpers\Statuses\HTTPResponseStatuses;
use App\Http\Controllers\Controller;
use App\Http\Requests\Catalog\ProductCreationRequest;
use App\Http\Requests\Catalog\ProductUpdateRequest;
use App\Models\Catalog\Category;
use App\Models\Catalog\Product;
use App\Models\UnitMeasure;
use App\Services\Catalog\CategoryService;
use App\Services\Catalog\ProductService;
use App\Services\ImageService;
use Illuminate\Http\JsonResponse;

class ProductManagementController extends Controller
{
    public function index(): ResponsePaginationData
    {
        $products = Product::paginate(10);

        $productsDto = new ProductDtoCollection($products->items());

        return new ResponsePaginationData([
            'paginator' => $products,
            'collection' => $productsDto,
        ]);
    }

    public function getCreateData(): ResponseData
    {
        $unitsMeasure = UnitMeasure::all()->all();
        $categories = Category::all()->all();

        $unitsMeasureDtoCollection = new UnitMeasureDtoCollection($unitsMeasure);
        $categoriesDtoCollection = new CategoryDtoCollection($categories);

        return new ResponseData([
            'data' => [
                'unitsMeasure' => $unitsMeasureDtoCollection->only(['id', 'name'])->toArray(),
                'categories' => $categoriesDtoCollection->only(['id', 'name'])->toArray()
            ]
        ]);
    }

    public function store(ProductCreationRequest $request): JsonResponse
    {
        return ProductManagementEntityService::store($request);
    }

    /**
     * @param int $id
     * @return ResponseData
     */
    public function getUpdateData(int $id)
    {
        $product = ProductService::getById($id);

        $unitsMeasure = UnitMeasure::all()->all();
        $categories = Category::all()->all();

        $productDto = ProductDto::fromModel($product);
        $unitsMeasureDtoCollection = new UnitMeasureDtoCollection($unitsMeasure);
        $categoriesDtoCollection = new CategoryDtoCollection($categories);

        return new ResponseData([
            'data' => [
                'product' => $productDto->toArray(),
                'unitsMeasure' => $unitsMeasureDtoCollection->only(['id', 'name'])->toArray(),
                'categories' => $categoriesDtoCollection->only(['id', 'name'])->toArray()
            ]
        ]);
    }

    public function update(ProductUpdateRequest $request, int $id)
    {
        return ProductManagementEntityService::update($request, $id);
    }
}
