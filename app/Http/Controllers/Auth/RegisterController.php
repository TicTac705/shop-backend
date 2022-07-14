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
    public function register(RegisterRequest $request): JsonResponse
    {
        $registerData = RegisterDto::fromRequest($request);

        return response()->json(RegisterEntityService::register($registerData), HTTPResponseStatuses::CREATED);
    }
}
