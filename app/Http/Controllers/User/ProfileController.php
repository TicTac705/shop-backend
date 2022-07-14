<?php

namespace App\Http\Controllers\User;

use App\EntityServices\User\ProfileEntityService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    private ProfileEntityService $profileEntityService;

    public function __construct(ProfileEntityService $profileEntityService)
    {
        $this->profileEntityService = $profileEntityService;
    }

    public function getUserInfo(): JsonResponse
    {
        return response()->json($this->profileEntityService->getUserInfo());
    }
}
