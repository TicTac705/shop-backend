<?php

namespace App\PivotModels\User;

use App\PivotModels\PivotBase;

/**
 * @property int $id
 * @property int $user_id
 * @property int $role_id
 *
 */
class UserRole extends PivotBase
{
    protected $table = 'users_roles';

    protected $fillable = [
        'user_id',
        'role_id'
    ];

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'role_id' => 'integer'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public static function create(
        int $userId,
        int $roleId
    ): self
    {
        $userRole = new self();

        $userRole->setUserId($userId);
        $userRole->setRoleId($roleId);

        return $userRole;
    }

    public function getUserId(): string
    {
        return $this->user_id;
    }

    public function getRoleId(): string
    {
        return $this->role_id;
    }

    public function setUserId(int $userId): self
    {
        $this->user_id = $userId;
        return $this;
    }

    public function setRoleId(int $roleId): self
    {
        $this->role_id = $roleId;
        return $this;
    }
}
