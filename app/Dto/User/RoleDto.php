<?php
namespace App\Dto\User;

use App\Dto\BaseDto;

class RoleDto extends BaseDto
{
    public int $id;
    public string $name;
    public string $slug;
    public string $updated_at;
    public string $created_at;
}
