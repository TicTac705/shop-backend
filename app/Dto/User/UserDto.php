<?php
namespace App\Dto\User;

use App\Dto\BaseDto;
use App\Models\User\User;
use Carbon\Carbon;

class UserDto extends BaseDto
{
    public int $id;
    public string $name;
    public string $email;
    public ?Carbon $emailVerifiedAt;
    public RoleDto $role;
    public int $updatedAt;
    public int $createdAt;

    public static function fromModel(User $user): self
    {
        return new self([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
            'emailVerifiedAt' => $user->email_verified_at,
            'role' => RoleDto::fromModel($user->role->first())->only('id', 'name', 'slug'),
            'updatedAt' => $user->updated_at->timestamp,
            'createdAt' => $user->created_at->timestamp,
        ]);
    }
}
