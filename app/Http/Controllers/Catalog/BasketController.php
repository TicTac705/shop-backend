<?php

namespace App\Http\Controllers\Catalog;

use App\Dto\Catalog\BasketDto;
use App\Http\Controllers\Controller;
use App\Http\Requests\Catalog\BasketItemAddingRequest;
use App\Services\Catalog\BasketService;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;

class BasketController extends Controller
{
    public function getList(): JsonResponse
    {
        return response()->json(BasketDto::fromModel(BasketService::getUserCart(Auth::user())));
    }

    public function store(BasketItemAddingRequest $request): JsonResponse
    {
        $basket = BasketService::getUserCart(Auth::user());

        return response()->json(BasketDto::fromModel(BasketService::getUserCart(Auth::user())));
    }
}
