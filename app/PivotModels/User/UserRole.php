<?php

namespace App\PivotModels\User;

use App\PivotModels\PivotBase;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property string $user_id
 * @property string $role_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 */
class UserRole extends PivotBase
{
    protected $collection  = 'users_roles';

    protected $fillable = [
        'user_id',
        'role_id'
    ];

    protected $casts = [
        'id' => 'string',
        'user_id' => 'string',
        'role_id' => 'string'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public static function create(
        string $userId,
        string $roleId
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

    public function setUserId(string $userId): self
    {
        $this->user_id = $userId;
        return $this;
    }

    public function setRoleId(string $roleId): self
    {
        $this->role_id = $roleId;
        return $this;
    }
}
