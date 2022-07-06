<?php

namespace App\EntityServices\Auth;

use App\Dto\Auth\RegisterDto;
use App\Dto\ResponseData;
use App\Dto\User\UserDto;
use App\Helpers\Statuses\HTTPResponseStatuses;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User\Role;
use App\PivotModels\User\UserRole;
use App\Services\User\UserService;

class RegisterEntityService
{
    public function register(RegisterRequest $request): ResponseData
    {
        $registerData = RegisterDto::fromRequest($request);

        $userNew = UserService::save($registerData);

        UserRole::create($userNew->id, Role::getIdBySlug('user'))->save();

        return new ResponseData(['data' => UserDto::fromModel($userNew), 'status' => HTTPResponseStatuses::CREATED]);
    }
}
