<?php

namespace App\EntityServices\Auth;

use App\Dto\Auth\RegisterDto;
use App\Helpers\Statuses\HTTPResponseStatuses;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User\User;
use App\PivotModels\User\UserRole;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class RegisterEntityService
{
    /**
     * @param RegisterRequest $request
     * @return Application|ResponseFactory|Response
     */
    public function register(RegisterRequest $request)
    {
        $registerData = RegisterDto::fromRequest($request);

        $roleId = UserRole::getIdBySlug('user');

        User::create(
            $registerData->name,
            $registerData->email,
            $registerData->password,
            $roleId
        )->save();

        return response('', HTTPResponseStatuses::OK);
    }
}
