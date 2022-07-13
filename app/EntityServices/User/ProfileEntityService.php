<?php

namespace App\EntityServices\User;

use App\Dto\ResponseData;
use App\Dto\User\UserDto;
use Illuminate\Support\Facades\Auth;

class ProfileEntityService
{
    public function getUserInfo(): ResponseData
    {
        $userDto = UserDto::fromModel(Auth::user());

        return new ResponseData($userDto);
    }
}
