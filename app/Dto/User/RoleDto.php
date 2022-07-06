<?php
namespace App\Dto\User;

use App\Dto\BaseDto;
use App\Models\User\Role;

class RoleDto extends BaseDto
{
    public int $id;
    public string $name;
    public string $slug;
    public int $updatedAt;
    public int $createdAt;

    public static function fromModel(Role $role): self
    {
        return new self([
            'id' => $role->id,
            'name' => $role->name,
            'slug' => $role->slug,
            'updatedAt' => $role->updated_at->timestamp,
            'createdAt' => $role->created_at->timestamp,
        ]);
    }
}
