<?php
namespace App\Dto\User;

use App\Dto\BaseDto;
use App\Models\User\Role;

class RoleLightForTokenDto extends BaseDto
{
    public string $slug;

    public static function fromModel(Role $role): self
    {
        return new self([
            'slug' => $role->getSlug(),
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
