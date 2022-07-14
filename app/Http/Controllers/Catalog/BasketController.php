<?php

namespace App\Http\Controllers\Catalog;

use App\Dto\Catalog\ProductAddedToCartDto;
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

    public function store(BasketItemAddingRequest $request): JsonResponse
    {
        $productAddedToCartDto = ProductAddedToCartDto::fromRequest($request);

        return response()->json(BasketEntityService::store($productAddedToCartDto));
    }
}
