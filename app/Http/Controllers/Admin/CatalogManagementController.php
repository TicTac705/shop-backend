<?php

namespace App\Http\Controllers\Admin;

use App\Dto\Catalog\CategoryDtoCollection;
use App\Dto\Catalog\ProductDto;
use App\Dto\Catalog\ProductDtoCollection;
use App\Dto\ResponseData;
use App\Dto\ResponsePaginationData;
use App\Dto\UnitMeasureDtoCollection;
use App\EntityServices\Admin\CatalogManagementEntityService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Catalog\AdditionProductRequest;
use App\Models\Catalog\Category;
use App\Models\Catalog\Product;
use App\Models\UnitMeasure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CatalogManagementController extends Controller
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

    public function store(AdditionProductRequest $request): JsonResponse
    {
        return CatalogManagementEntityService::store($request);
    }

    public function getUpdateData(int $id): ResponseData
    {
        $product = Product::find($id);
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

    public function update(Request $request)
    {

    }
}
