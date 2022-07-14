<?php

namespace App\Http\Controllers\User;

use App\EntityServices\User\ProfileEntityService;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    public function getUserInfo():JsonResponse
    {
        return response()->json(ProfileEntityService::getUserInfo());
    }
}
