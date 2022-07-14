<?php

namespace App\EntityServices\Auth;

use App\Dto\Auth\RegisterDto;
use App\Dto\User\UserDto;
use App\Models\User\Role;
use App\Services\User\UserRoleService;
use App\Services\User\UserService;

class RegisterEntityService
{
    private UserService $userService;
    private UserRoleService $userRoleService;

    public function __construct(
        UserService     $userService,
        UserRoleService $userRoleService
    )
    {
        $this->userService = $userService;
        $this->userRoleService = $userRoleService;
    }

    public function register(RegisterDto $dto): UserDto
    {
        $userNew = $this->userService->save($dto);

        $this->userRoleService->save($userNew->getId(), Role::getIdBySlug('user'));

        return UserDto::fromModel($userNew);
    }
}
