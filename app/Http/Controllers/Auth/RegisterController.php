<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\RegisterRequest;
use App\Models\Auth\User;
use App\Models\Auth\UserRole;
use Illuminate\Http\RedirectResponse;

class RegisterController extends Controller
{
    public function index(): void
    {
    }

    public function register(RegisterRequest $request): RedirectResponse
    {
        $request->validated();

        $roleId = UserRole::getIdBySlug('user');

        User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'password' => bcrypt($request['password']),
            'role_id' => $roleId
        ]);

        return redirect()->route('catalog');
    }
}
