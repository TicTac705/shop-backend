<?php

namespace App\Http\Controllers\User;

use App\Dto\ResponseData;
use App\EntityServices\User\ProfileEntityService;
use App\Http\Controllers\Controller;

class ProfileController extends Controller
{
    public function getUserInfo():ResponseData
    {
        return ProfileEntityService::getUserInfo();
    }
}
