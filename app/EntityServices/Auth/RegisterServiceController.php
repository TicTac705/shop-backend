<?php

namespace App\EntityServices\Auth;

use App\Dto\Auth\RegisterData;
use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Auth\User;
use App\Models\Auth\UserRole;
use Illuminate\Http\RedirectResponse;

class RegisterServiceController
{
    public function register(RegisterRequest $request): RedirectResponse
    {
        $registerData = RegisterData::fromRequest($request);

        $roleId = UserRole::getIdBySlug('user');

        User::create(
            $registerData->name,
            $registerData->email,
            $registerData->password,
            $roleId
        )->save();

        return redirect()->route('home');
    }
}
