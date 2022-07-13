<?php

namespace App\Services\User;

use App\PivotModels\User\UserRole;

class UserRoleService
{
    public function save(int $userId, int $roleId): UserRole
    {
        return UserRole::create($userId, $roleId)->saveAndReturn();
    }
}
