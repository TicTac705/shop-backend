<?php

namespace App\Http\Controllers\Auth;

use App\EntityServices\Auth\LoginServiceController;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthorizeRequest;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Psr\Http\Message\StreamInterface;

class LoginController extends Controller
{
    public function index(): void
    {
    }

    /**
     * @param AuthorizeRequest $request
     * @return JsonResponse
     */
    public function signIn(AuthorizeRequest $request)
    {
        return LoginServiceController::signin($request);
    }

    public function refresh(Request $request): JsonResponse
    {
        return LoginServiceController::refresh($request);
    }

    public function logout(): JsonResponse
    {
        return LoginServiceController::logout();
    }
}
