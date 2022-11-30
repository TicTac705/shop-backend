<?php

namespace Tests\Helpers;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;

trait UserTrait
{
    use MakesHttpRequests, RoleTrait;

    /** @var User */
    protected User $admin;
    /** @var User */
    protected User $user;

    protected string $defaultAdminEmail = 'super-user@shop.local';
    protected string $defaultUserEmail = 'test-user@shop.local';
    protected string $defaultPassword = 'password';

    public function createAdmin(?string $email = null): User
    {
        $this->admin = User::factory()->state(new Sequence(
            ['role_ids' => [$this->getAdminRole()], 'email' => $email ?? $this->defaultAdminEmail]
        ))->create();

        return $this->admin;
    }

    public function createUser(?string $email = null): User
    {
        $this->user = User::factory()->state(new Sequence(
            ['role_ids' => [$this->getUserRole()], 'email' => $email ?? $this->defaultUserEmail]
        ))->create();

        return $this->user;
    }
}
