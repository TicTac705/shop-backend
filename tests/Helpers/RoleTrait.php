<?php

namespace Tests\Helpers;

use App\Models\User\Role;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\Sequence;

trait RoleTrait
{
    protected Collection $roles;

    protected function createDefaultsRoles(): void
    {
        $this->roles = Role::factory()->count(3)->state(new Sequence(
            ['name' => 'Admin', 'slug' => 'admin'],
            ['name' => 'Manager', 'slug' => 'manager'],
            ['name' => 'User', 'slug' => 'user']
        ))->create();
    }

    protected function getAdminRole(): Role
    {
        return $this->roles->where('slug', '=', 'admin')->first();
    }
}
