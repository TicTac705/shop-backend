<?php

namespace App\Http\Controllers\Catalog;

use App\Dto\Catalog\ProductAddedToBasketDto;
use App\Dto\Catalog\ProductUpdatedToBasketDto;
use App\EntityServices\Catalog\BasketEntityService;
use App\Exceptions\NonExistingBasketItemException;
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

    public function store(BasketItemAddingRequest $request): JsonResponse
    {
        $productAddedToCartDto = ProductAddedToBasketDto::fromRequest($request);

        return response()->json($this->basketEntityService->store($productAddedToCartDto));
    }

    public function updateQuantity(BasketItemAddingRequest $request): JsonResponse
    {
        $productAddedToCartDto = ProductUpdatedToBasketDto::fromRequest($request);

        return response()->json($this->basketEntityService->updateQuantity($productAddedToCartDto));
    }

    /**
     * @throws NonExistingBasketItemException
     */
    public function destroy(int $id): JsonResponse
    {
        $this->basketEntityService->destroy($id);
        return response()->json(['message' => 'Item successfully deleted']);
    }
}
