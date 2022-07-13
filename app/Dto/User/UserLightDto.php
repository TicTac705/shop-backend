<?php
namespace App\Dto\User;

use App\Dto\BaseDto;
use App\Models\User\User;

class UserLightDto extends BaseDto
{
    public int $id;
    public string $name;

    public static function fromModel(User $user): self
    {
        return new self([
            'id' => $user->id,
            'name' => $user->name
        ]);
    }
}
