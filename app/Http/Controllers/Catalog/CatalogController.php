<?php

namespace App\Http\Controllers\Catalog;

use App\Dto\ResponsePaginationData;
use App\EntityServices\Catalog\CatalogEntityService;
use App\Http\Controllers\Controller;

class CatalogController extends Controller
{
    public function getList(): ResponsePaginationData
    {
        return CatalogEntityService::getList();
    }
}
