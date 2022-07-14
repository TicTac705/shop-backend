<?php

namespace App\EntityServices\Auth;

use App\Dto\Auth\RegisterDto;
use App\Dto\User\UserDto;
use App\Models\User\Role;
use App\Services\User\UserRoleService;
use App\Services\User\UserService;

class RegisterEntityService
{
    public function register(RegisterDto $dto): UserDto
    {
        $userNew = UserService::save($dto);

        UserRoleService::save($userNew->getId(), Role::getIdBySlug('user'));

        return UserDto::fromModel($userNew);
    }
}
