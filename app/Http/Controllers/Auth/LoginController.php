<?php

namespace App\Http\Controllers\Auth;

use App\Dto\Auth\AuthorizeDto;
use App\EntityServices\Auth\LoginEntityService;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthorizeRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

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
        $authDTO = AuthorizeDto::fromRequest($request);

        return LoginEntityService::signin($authDTO);
    }

    public function refresh(Request $request): JsonResponse
    {
        return LoginEntityService::refresh($request);
    }

    public function logout(): JsonResponse
    {
        return LoginEntityService::logout();
    }
}
