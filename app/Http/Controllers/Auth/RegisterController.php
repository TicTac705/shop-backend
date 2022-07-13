<?php

namespace App\Http\Controllers\Auth;

use App\Dto\ResponseData;
use App\EntityServices\Auth\RegisterEntityService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;

class RegisterController extends Controller
{
    /**
     * @param RegisterRequest $request
     * @return ResponseData
     */
    public function register(RegisterRequest $request)
    {
        return RegisterEntityService::register($request);
    }
}
