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
    public ?int $updatedAt;
    public ?int $createdAt;

    public static function fromModel(User $user): self
    {
        return new self([
            'id' => $user->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'emailVerifiedAt' => $user->getEmailVerifiedAt(),
            'role' => RoleDto::fromModel($user->role()->first()),
            'updatedAt' => $user->getUpdatedAtTimestamp(),
            'createdAt' => $user->getCreatedAtTimestamp(),
        ]);
    }
}
