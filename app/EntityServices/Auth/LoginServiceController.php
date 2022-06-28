<?php

namespace App\EntityServices\Auth;

use App\Helpers\Statuses\HTTPResponseStatuses;
use App\Http\Requests\Auth\AuthorizeRequest;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginServiceController
{
    public function signIn(AuthorizeRequest $request): JsonResponse
    {
        $request->validated();

        $loginData = $request->only('email', 'password');

        if (!Auth::attempt($loginData)) {
            return response()->json(
                [
                    'message' => 'Incorrect data for authorization'
                ],
                HTTPResponseStatuses::UNAUTHORIZED);
        }

        $token = Auth::user()->createToken(config('app.name'));
        $token->token->expires_at = Carbon::now()->addDay();
        $token->token->save();

        return response()->json([
            'token' => $token->accessToken,
            'expires_at' => Carbon::parse($token->token->expires_at)->toDateTimeString()
        ]);
    }

    public function logout(Request $request): JsonResponse
    {
        $request->user()->token()->revoke();

        return response()->json([
            'message' => 'You successfully logged out',
        ]);
    }
}
