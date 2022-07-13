<?php

namespace App\Http\Controllers\Auth;

use App\EntityServices\Auth\LoginEntityService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthorizeRequest;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    public function signIn(AuthorizeRequest $request)
    {
        return LoginEntityService::signin($request);
    }

    public function refresh(): JsonResponse
    {
        return LoginEntityService::refresh();
    }

    public function logout(): JsonResponse
    {
        return LoginEntityService::logout();
    }
}
