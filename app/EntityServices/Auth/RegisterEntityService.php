<?php

namespace App\EntityServices\Auth;

use App\Dto\Auth\RegisterDto;
use App\Dto\ResponseData;
use App\Dto\User\UserDto;
use App\Helpers\Statuses\HTTPResponseStatuses;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User\Role;
use App\Services\User\UserRoleService;
use App\Services\User\UserService;

class RegisterEntityService
{
    public function register(RegisterRequest $request): ResponseData
    {
        $registerData = RegisterDto::fromRequest($request);

        $userNew = UserService::save($registerData);

        UserRoleService::save($userNew->id, Role::getIdBySlug('user'));

        return new ResponseData(UserDto::fromModel($userNew), HTTPResponseStatuses::CREATED);
    }
}
