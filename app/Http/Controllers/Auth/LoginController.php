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
    private LoginEntityService $loginEntityService;

    public function __construct(LoginEntityService $loginEntityService)
    {
        $this->loginEntityService = $loginEntityService;
    }

    /**
     * @throws AuthErrorException
     */
    public function signIn(AuthorizeRequest $request): JsonResponse
    {
        $authDTO = AuthorizeDto::fromRequest($request);
        return response()->json($this->loginEntityService->signin($authDTO));
    }

    public function refresh(): JsonResponse
    {
        return response()->json($this->loginEntityService->refresh());
    }

    public function logout(): JsonResponse
    {
        $this->loginEntityService->logout();
        return response()->json(['message' => 'You successfully logged out']);
    }
}
