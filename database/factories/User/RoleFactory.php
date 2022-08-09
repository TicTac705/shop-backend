<?php

namespace Database\Factories\User;

use App\Models\User\Role;
use Illuminate\Database\Eloquent\Factories\Factory;

class RoleFactory extends Factory
{
    protected $model = Role::class;

    public function definition(): array
    {
        return [
            'name' => '',
            'slug' => '',
        ];
    }
}
