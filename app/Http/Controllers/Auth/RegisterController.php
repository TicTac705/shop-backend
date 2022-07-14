<?php

namespace App\Http\Controllers\Auth;

use App\Dto\Auth\RegisterDto;
use App\EntityServices\Auth\RegisterEntityService;
use App\Helpers\Statuses\HTTPResponseStatuses;
use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\RegisterRequest;
use Illuminate\Http\JsonResponse;

class RegisterController extends Controller
{
    private RegisterEntityService $registerEntityService;

    public function __construct(RegisterEntityService $registerEntityService)
    {
        $this->registerEntityService = $registerEntityService;
    }

    public function register(RegisterRequest $request): JsonResponse
    {
        $registerData = RegisterDto::fromRequest($request);

        return response()->json($this->registerEntityService->register($registerData), HTTPResponseStatuses::CREATED);
    }
}
