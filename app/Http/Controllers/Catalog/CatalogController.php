<?php

namespace App\Http\Controllers\Catalog;

use App\Dto\Catalog\ProductDtoCollection;
use App\Dto\ResponsePaginationData;
use App\Http\Controllers\Controller;
use App\Models\Catalog\Product;

class CatalogController extends Controller
{
    public function index(): ResponsePaginationData
    {
        //Всего эл
        //Кол-во на одной странице

        //Убрать обращения к БД из контроллеров
        //Убрать всю логику
        //DtoCollection придумать замену


        $products = Product::paginate(10);

        $productsDto = new ProductDtoCollection($products->items());

        return new ResponsePaginationData([
            'paginator' => $products,
            'collection' => $productsDto,
        ]);
    }
}
