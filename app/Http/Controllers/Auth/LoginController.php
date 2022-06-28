<?php

namespace App\Http\Controllers\Auth;

use App\EntityServices\Auth\LoginServiceController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthorizeRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function index(): void
    {
    }

    public function signIn(AuthorizeRequest $request): JsonResponse
    {
        return LoginServiceController::signin($request);
    }

    public function logout(Request $request): JsonResponse
    {
        return LoginServiceController::logout($request);
    }
}
