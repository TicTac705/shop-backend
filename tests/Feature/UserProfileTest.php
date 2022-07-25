<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use JWTAuth;
use Tests\TestCase;

class UserProfileTest extends TestCase
{
    use RefreshDatabase;

    public function testUserInformation(): void
    {
        $token = JWTAuth::attempt(['email' => $this->admin->getEmail(), 'password' => $this->defaultPassword]);
        $this->defaultHeaders = ['Authorization' => "Bearer $token"];

        $response = $this->getJson(route('profile'));

        $response->assertSuccessful();
        $this->assertAuthenticated();

        $this->assertNotNull($response->original->name);
        $this->assertNotNull($response->original->email);
        $this->assertNotNull($response->original->roles);
    }

    public function testUnsuccessfulUserInformation(): void
    {
        $response = $this->getJson(route('profile'));

        $response->assertUnauthorized();
    }
}
