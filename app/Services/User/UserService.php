<?php
namespace App\Services\User;

use App\Dto\Auth\RegisterDto;
use App\Models\User\User;

class UserService
{
    public function save(RegisterDto $data): User
    {
        return User::create(
            $data->name,
            $data->email,
            $data->password,
        )->saveAndReturn();
    }
}
