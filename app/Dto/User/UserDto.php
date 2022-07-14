<?php
namespace App\Dto\User;

use App\Dto\BaseDto;
use App\Models\User\User;
use Carbon\Carbon;

class UserDto extends BaseDto
{
    public string $name;
    public string $email;
    public ?Carbon $emailVerifiedAt;
    /** @var \App\Dto\User\RoleLightDto[]  */
    public array $roles;
    public ?int $updatedAt;
    public ?int $createdAt;

    public static function fromModel(User $user): self
    {
        return new self([
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'emailVerifiedAt' => $user->getEmailVerifiedAt(),
            'roles' => RoleLightDto::fromList($user->role()->getResults()->all()),
            'updatedAt' => $user->getUpdatedAtTimestamp(),
            'createdAt' => $user->getCreatedAtTimestamp(),
        ]);
    }
}
