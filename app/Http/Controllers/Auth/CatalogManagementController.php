<?php

namespace App\Http\Controllers\Auth;

use App\EntityServices\Catalog\CatalogManagementServiceController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Catalog\AdditionProductRequest;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class CatalogManagementController extends Controller
{
    public function index()
    {

    }

    public function create()
    {

    }

    /**
     * @param AdditionProductRequest $request
     * @return Application|ResponseFactory|Response
     */
    public function store(AdditionProductRequest $request)
    {
        return CatalogManagementServiceController::store($request);
    }
}
