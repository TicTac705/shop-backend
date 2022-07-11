<?php

namespace App\Dto\User;

use App\Dto\BaseDtoCollection;
use App\Models\User\Role;

class RoleDtoCollection extends BaseDtoCollection
{
    /**
     * @param Role[] $data
     */
    public function __construct(array $data)
    {
        $collection = array_map(fn(Role $item):RoleDto => RoleDto::fromModel($item), $data);

        parent::__construct($collection);
    }
}
