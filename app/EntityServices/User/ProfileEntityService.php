<?php

namespace App\EntityServices\User;

use App\Dto\User\UserDto;
use Illuminate\Support\Facades\Auth;

class ProfileEntityService
{
    public function getUserInfo(): UserDto
    {
        return UserDto::fromModel(Auth::user());
    }
}
