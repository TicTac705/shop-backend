<?php

namespace App\Http\Controllers\Catalog;

use App\Dto\Catalog\BasketDto;
use App\Dto\ResponseData;
use App\Http\Controllers\Controller;
use App\Services\Catalog\BasketService;
use Illuminate\Support\Facades\Auth;

class BasketController extends Controller
{
    public function getList()
    {
        return new ResponseData(BasketDto::fromModel(BasketService::getUserCart(Auth::user())));
    }
}
