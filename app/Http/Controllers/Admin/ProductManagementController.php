<?php

namespace App\Http\Controllers\Admin;

use App\Dto\ResponseData;
use App\Dto\ResponsePaginationData;
use App\EntityServices\Admin\ProductManagementEntityService;
use App\EntityServices\Catalog\CatalogEntityService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Catalog\ProductCreationRequest;
use App\Http\Requests\Catalog\ProductUpdateRequest;

class ProductManagementController extends Controller
{
    public function getList(): ResponsePaginationData
    {
        return CatalogEntityService::getList();
    }

    public function getCreateData(): ResponseData
    {
        return ProductManagementEntityService::getCreateData();
    }

    public function store(ProductCreationRequest $request): ResponseData
    {
        return ProductManagementEntityService::store($request);
    }

    public function getUpdateData(int $id): ResponseData
    {
        return ProductManagementEntityService::getUpdateData($id);
    }

    public function update(ProductUpdateRequest $request, int $id): ResponseData
    {
        return ProductManagementEntityService::update($request, $id);
    }
}
