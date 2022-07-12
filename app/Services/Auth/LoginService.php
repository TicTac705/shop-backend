<?php

namespace App\Services\Auth;

use Illuminate\Http\JsonResponse;

class LoginService
{
    public function createNewToken($token): JsonResponse
    {
        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth('api')->factory()->getTTL() * 120 * 24
        ]);
    }
}
