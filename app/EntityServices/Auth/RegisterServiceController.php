<?php

namespace App\EntityServices\Auth;

use App\Dto\Auth\RegisterData;
use App\Helpers\Statuses\HTTPResponseStatuses;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\User\User;
use App\Models\User\UserRole;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Response;

class RegisterServiceController
{
    /**
     * @param RegisterRequest $request
     * @return Application|ResponseFactory|Response
     */
    public function register(RegisterRequest $request)
    {
        $registerData = RegisterData::fromRequest($request);

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
