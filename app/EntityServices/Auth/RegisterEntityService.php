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

    public function __construct(UserService $userService)
    {
        $this->userService = $userService;
    }

    public function register(RegisterDto $dto): UserDto
    {
        $userNew = $this->userService->save($dto);
        return UserDto::fromModel($userNew);
    }
}
