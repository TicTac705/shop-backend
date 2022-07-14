<?php

namespace App\Http\Controllers\Auth;

use App\Dto\Auth\AuthorizeDto;
use App\EntityServices\Auth\LoginEntityService;
use App\Exceptions\AuthErrorException;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\AuthorizeRequest;
use Illuminate\Http\JsonResponse;

class LoginController extends Controller
{
    /**
     * @throws AuthErrorException
     */
    public function signIn(AuthorizeRequest $request): JsonResponse
    {
        $authDTO = AuthorizeDto::fromRequest($request);
        return response()->json(LoginEntityService::signin($authDTO));
    }

    public function refresh(): JsonResponse
    {
        return response()->json(LoginEntityService::refresh());
    }

    public function logout(): JsonResponse
    {
        LoginEntityService::logout();
        return response()->json(['message' => 'You successfully logged out']);
    }
}
