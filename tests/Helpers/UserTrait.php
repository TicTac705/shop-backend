<?php

namespace Tests\Helpers;

use App\Models\User\User;
use Illuminate\Foundation\Testing\Concerns\MakesHttpRequests;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\TestResponse;
use JWTAuth;

trait UserTrait
{
    use MakesHttpRequests, RoleTrait;

    /** @var User */
    protected User $user;

    private string $defaultEmail = 'test@example.com';
    private string $defaultPassword = 'password';

    public function createAdmin(?string $email = null): User
    {
        $this->createDefaultsRoles();

        $this->user = User::factory()->hasAttached($this->getAdminRole())->create([
            'email' => $email ?? $this->defaultEmail,
            'password' => Hash::make($this->defaultPassword),
        ]);

        return $this->user;
    }

    public function sendAuthorizationRequest(string $email, ?string $password = null): TestResponse
    {
        return $this->postJson(route('signIn'), [
            'email' => $email,
            'password' => $password ?? $this->defaultPassword,
        ]);
    }

    public function sendRegistrationRequest(string $name, string $email): TestResponse
    {
        return $this->postJson(route('signUp'), [
            'name' => $name,
            'email' => $email,
            'password' => $this->defaultPassword,
            'password_confirmation' => $this->defaultPassword
        ]);
    }

    /**
     * @return string[]
     */
    public function authorize(): array
    {
        $token = JWTAuth::attempt(['email' => $this->user->getEmail(), 'password' => $this->defaultPassword]);
        return ['Authorization' => "Bearer $token"];
    }
}
