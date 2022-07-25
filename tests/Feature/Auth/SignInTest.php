<?php

namespace Tests\Feature\Auth;

use Illuminate\Foundation\Testing\RefreshDatabase;
use JWTAuth;
use Tests\TestCase;

class SignInTest extends TestCase
{
    use RefreshDatabase;

    public function testSuccessfulAuthorization(): void
    {
        $response = $this->postJson(route('signIn'), [
            'email' => $this->admin->getEmail(),
            'password' => $this->defaultPassword,
        ]);

        $response = $response->assertSuccessful();

        $token = $response->getOriginalContent()->access_token;

        $payload = JWTAuth::setToken($token)->getPayload();
        $this->assertEquals($this->admin->getId(), $payload['sub']);
    }

    public function testBadAuthorization(): void
    {
        $response = $this->postJson(route('signIn'), [
            'email' => $this->admin->getEmail(),
            'password' => 'password1',
        ]);

        $this->assertGuest();
        $response->assertUnauthorized();
    }
}
