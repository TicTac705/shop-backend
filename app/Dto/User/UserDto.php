<?php
namespace App\Dto\User;

use App\Dto\BaseDto;
use App\Models\User\User;

class UserDto extends BaseDto
{
    public int $id;
    public string $name;
    public string $email;
    public ?string $email_verified_at;
    public string $updated_at;
    public string $created_at;

    public ?RoleDto $role;

    public function __construct(array $parameters = [])
    {
        parent::__construct($parameters);

        dd(User::find($this->id)->role->first()->toArray());
        $this->role = new RoleDto(User::find($this->id)->role->first()->hide('pivot')->toArray());
    }
}
