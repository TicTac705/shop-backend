<?php

namespace App\Http\Controllers\Catalog;

use App\Dto\Catalog\ProductAddedToBasketDto;
use App\Dto\Catalog\ProductUpdatedToBasketDto;
use App\EntityServices\Catalog\BasketEntityService;
use App\Exceptions\Basket\NonExistingBasketItemException;
use App\Exceptions\Catalog\InvalidQuantityProductException;
use App\Exceptions\Catalog\UnavailabilityException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Catalog\BasketItemAddingRequest;
use App\Http\Requests\Catalog\BasketItemUpdatingRequest;
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

    /**
     * @throws UnavailabilityException
     * @throws InvalidQuantityProductException
     */
    public function store(BasketItemAddingRequest $request): JsonResponse
    {
        $productAddedToCartDto = ProductAddedToBasketDto::fromRequest($request);

        return response()->json($this->basketEntityService->store($productAddedToCartDto));
    }

    /**
     * @throws UnavailabilityException
     * @throws InvalidQuantityProductException
     */
    public function updateQuantity(BasketItemUpdatingRequest $request): JsonResponse
    {
        $productAddedToCartDto = ProductUpdatedToBasketDto::fromRequest($request);

        return response()->json($this->basketEntityService->updateQuantity($productAddedToCartDto));
    }

    /**
     * @throws NonExistingBasketItemException
     */
    public function destroy(string $id): JsonResponse
    {
        $this->basketEntityService->destroy($id);
        return response()->json(['message' => 'Item successfully deleted']);
    }
}
