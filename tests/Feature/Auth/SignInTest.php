<?php

namespace Tests\Feature\Auth;

use App\Helpers\Statuses\HTTPResponseStatuses;
use Illuminate\Foundation\Testing\RefreshDatabase;
use JWTAuth;
use Tests\Helpers\UserTrait;
use Tests\TestCase;

class SignInTest extends TestCase
{
    use UserTrait, RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createAdmin();
    }

    public function testSuccessfulAuthorization(): void
    {
        $response = $this->sendAuthorizationRequest($this->user->getEmail());

        $response = $response->assertSuccessful();

        $token = $response->getOriginalContent()->access_token;

        $payload = JWTAuth::setToken($token)->getPayload();
        $this->assertEquals($this->user->getId(), $payload['sub']);
    }

    public function testBadAuthorization(): void
    {
        $response = $this->sendAuthorizationRequest($this->user->getEmail(), 'password1');

        $this->assertGuest();
        $response->assertStatus(HTTPResponseStatuses::UNAUTHORIZED);
    }
}
