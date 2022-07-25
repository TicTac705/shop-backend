<?php

namespace Tests\Feature\Auth;

use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SignUpTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccessfulRegistration(): void
    {
        $response = $this->postJson(route('signUp'), [
            'name' => 'Test',
            'email' => 'test2@example.com',
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertSuccessful();

        /** @var User $user */
        $user = User::query()->where('email', '=', 'test2@example.com')->first();

        $this->assertNotNull($user);
        $this->assertTrue($user->hasRole('user'));
    }

    public function testBadRegistration(): void
    {
        $response = $this->postJson(route('signUp'), [
            'name' => 'Test',
            'email' => $this->defaultAdminEmail,
            'password' => 'password',
            'password_confirmation' => 'password'
        ]);

        $response->assertUnprocessable();

        $this->assertTrue($response->original['data']->has('email'));
    }
}
