<?php

namespace App\EntityServices\Auth;

use App\Dto\Auth\AuthorizeData;
use App\Helpers\Statuses\HTTPResponseStatuses;
use App\Http\Requests\Auth\AuthorizeRequest;
use App\Services\Auth\LoginService;
use GuzzleHttp\Exception\BadResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginServiceController
{
    /**
     * @param AuthorizeRequest $request
     * @return JsonResponse
     */
    public function signIn(AuthorizeRequest $request): JsonResponse
    {
        $authData = AuthorizeData::fromRequest($request);

        try {
            return response()->json(LoginService::createToken($authData));
        } catch (BadResponseException $e) {
            if ($e->getCode() === HTTPResponseStatuses::BAD_REQUEST) {
                return response()->json(['message' => 'Invalid Request'], $e->getCode());
            } else if ($e->getCode() === HTTPResponseStatuses::UNAUTHORIZED) {
                return response()->json(['message' => 'Your credentials are incorrect'], $e->getCode());
            }

            return response()->json(['message' => 'Something went wrong on the server'], $e->getCode());
        }
    }

    public function refresh(Request $request): JsonResponse
    {
        try {
            return response()->json(LoginService::refreshToken($request->get('refresh_token')));
        } catch (BadResponseException $e) {
            if ($e->getCode() === HTTPResponseStatuses::BAD_REQUEST) {
                return response()->json(['message' => 'Invalid Request'], $e->getCode());
            } else if ($e->getCode() === HTTPResponseStatuses::UNAUTHORIZED) {
                return response()->json(['message' => 'Your credentials are incorrect'], $e->getCode());
            }

            return response()->json(['message' => 'Something went wrong on the server'], $e->getCode());
        }
    }

    public function logout(): JsonResponse
    {
        Auth::user()->token()->delete();

        return response()->json(['message' => 'You successfully logged out']);
    }
}
