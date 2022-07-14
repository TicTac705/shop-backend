<?php

namespace App\Http\Controllers\Catalog;

use App\Dto\Catalog\ProductAddedToBasketDto;
use App\EntityServices\Catalog\BasketEntityService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Catalog\BasketItemAddingRequest;
use Illuminate\Http\JsonResponse;

class BasketController extends Controller
{
    private BasketEntityService $basketEntityService;

    public function __construct(BasketEntityService $basketEntityService)
    {
        $this->basketEntityService = $basketEntityService;
    }

    public function getBasket(): JsonResponse
    {
        return response()->json($this->basketEntityService->getBasket());
    }

    public function storeOrUpdate(BasketItemAddingRequest $request): JsonResponse
    {
        $productAddedToCartDto = ProductAddedToBasketDto::fromRequest($request);

        return response()->json($this->basketEntityService->storeOrUpdate($productAddedToCartDto));
    }

    public function destroy(int $id): JsonResponse
    {
        $this->basketEntityService->destroy($id);
        return response()->json(['message' => 'Item successfully deleted']);
    }
}
