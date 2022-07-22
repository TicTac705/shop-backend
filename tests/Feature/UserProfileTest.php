<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\Helpers\UserTrait;
use Tests\TestCase;

class UserProfileTest extends TestCase
{
    use UserTrait, RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createAdmin();
    }

    public function testUserInformation(): void
    {
        $this->defaultHeaders = $this->authorize();

        $response = $this->getJson(route('profile'));

        $response->assertSuccessful();
    }
}
