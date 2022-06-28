<?php

namespace App\EntityServices\Auth;

use App\Http\Requests\Auth\RegisterRequest;
use App\Models\Auth\User;
use App\Models\Auth\UserRole;
use Illuminate\Http\RedirectResponse;

class RegisterServiceController
{
    public function register(RegisterRequest $request): RedirectResponse
    {
        $roleId = UserRole::getIdBySlug('user');

        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'role_id' => $roleId
        ]);

        return redirect()->route('home');
    }
}
