<?php
namespace App\Dto\User;

use App\Dto\BaseDto;
use App\Models\User\Role;

class RoleLightDto extends BaseDto
{
    public int $id;
    public string $name;

    public static function fromModel(Role $role): self
    {
        return new self([
            'id' => $role->getId(),
            'name' => $role->getName(),
        ]);
    }

    /**
     * @param Role[] $items
     * @return self[]
     */
    public function fromList(array $items): array
    {
        return array_map(fn(Role $item): self => self::fromModel($item), $items);
    }
}
