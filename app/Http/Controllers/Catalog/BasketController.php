<?php

namespace App\Http\Controllers\Catalog;

use App\Dto\Catalog\BasketDto;
use App\Dto\ResponseData;
use App\Http\Controllers\Controller;
use App\Http\Requests\Catalog\BasketItemAddingRequest;
use App\Services\Catalog\BasketService;
use Illuminate\Support\Facades\Auth;

class BasketController extends Controller
{
    public function getList(): ResponseData
    {
        return new ResponseData(BasketDto::fromModel(BasketService::getUserCart(Auth::user())));
    }

    public function store(BasketItemAddingRequest $request)
    {
        $basket = BasketService::getUserCart(Auth::user());

        return new ResponseData(BasketDto::fromModel(BasketService::getUserCart(Auth::user())));
    }
}
