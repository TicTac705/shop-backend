<?php

namespace App\EntityServices\Auth;

use App\Dto\Auth\AuthorizeDto;
use App\Helpers\Statuses\HTTPResponseStatuses;
use App\Services\Auth\LoginService;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginEntityService
{
    public function signIn(AuthorizeDto $authData): JsonResponse
    {
        if (!$token = JWTAuth::attempt($authData->toArray())) {
            return response()->json(['message' => 'Your credentials are incorrect'], HTTPResponseStatuses::UNAUTHORIZED);
        }

        return LoginService::createNewToken($token);
    }

    public function refresh(): JsonResponse
    {
        $token = JWTAuth::getToken();

        return LoginService::createNewToken(JWTAuth::refresh($token));
    }

    public function logout(): JsonResponse
    {
        auth()->logout();

        return response()->json(['message' => 'You successfully logged out']);
    }
}
