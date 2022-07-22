<?php

namespace Tests\Feature\Auth;

use App\Models\User\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\UserTrait;
use Tests\TestCase;

class SignUpTest extends TestCase
{
    use UserTrait, RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createAdmin();
    }

    public function testSuccessfulRegistration(): void
    {
        $email = 'test2@example.com';

        $response = $this->sendRegistrationRequest(
            'Test',
            $email
        );

        $response->assertSuccessful();

        /** @var User $user */
        $user = User::query()->where('email', '=', $email)->first();

        $this->assertNotNull($user);
        $this->assertEquals($user->getName(), $response->json('name'));
    }

    public function testBadRegistration(): void
    {
        $response = $this->sendRegistrationRequest(
            'Test',
            'test@example.com'
        );

        $response->assertUnprocessable();
    }
}
