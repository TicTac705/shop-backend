<?php

namespace App\EntityServices\Auth;

use App\Dto\Auth\AuthorizeDto;
use App\Helpers\Statuses\HTTPResponseStatuses;
use App\Http\Requests\Auth\AuthorizeRequest;
use App\Services\Auth\LoginService;
use Illuminate\Http\JsonResponse;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class LoginEntityService
{
    public function signIn(AuthorizeRequest $request): JsonResponse
    {
        $authDTO = AuthorizeDto::fromRequest($request);

        try {
            if (!$token = JWTAuth::attempt($authDTO->toArray())) {
                return response()->json(['message' => 'Your credentials are incorrect'], HTTPResponseStatuses::UNAUTHORIZED);
            }
        } catch (JWTException $e) {
            return response()->json(['message' => 'Could not create token'], HTTPResponseStatuses::INTERNAL_SERVER_ERROR);
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
