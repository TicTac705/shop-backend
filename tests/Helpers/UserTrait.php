<?php

namespace Tests\Helpers;

use App\Models\User\User;
use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;
use Illuminate\Support\Facades\Hash;

trait UserTrait
{
    use MakesHttpRequests, RoleTrait;

    /** @var User */
    protected User $admin;
    /** @var User */
    protected User $user;

    protected string $defaultAdminEmail = 'test-admin@example.com';
    protected string $defaultUserEmail = 'test-user@example.com';
    protected string $defaultPassword = 'password';

    public function createAdmin(?string $email = null): User
    {
        $this->admin = User::factory()->hasAttached($this->getAdminRole())->create([
            'email' => $email ?? $this->defaultAdminEmail,
            'password' => Hash::make($this->defaultPassword),
        ]);

        return $this->admin;
    }

    public function createUser(?string $email = null): User
    {
        $this->user = User::factory()->hasAttached($this->getUserRole())->create([
            'email' => $email ?? $this->defaultUserEmail,
            'password' => Hash::make($this->defaultPassword),
        ]);

        return $this->user;
    }
}
