<?php

namespace App\Services\User;

use App\Dto\Auth\RegisterDto;
use App\Models\User\Role;
use App\Models\User\User;

class UserService
{
    public function save(RegisterDto $data): User
    {
        /** @var Role $userRole */
        $userRole = Role::query()->where('slug', '=', 'user')->first();

        return User::create(
            $data->name,
            $data->email,
            $data->password,
            [$userRole->getId()]
        )->saveAndReturn();
    }

    public function isAdmin(User $model): bool
    {
        return $model->hasRole('admin');
    }
}
