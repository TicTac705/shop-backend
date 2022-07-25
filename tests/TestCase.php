<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;
use Tests\Helpers\CategoryTrait;
use Tests\Helpers\ProductTrait;
use Tests\Helpers\UnitMeasureTrait;
use Tests\Helpers\UserTrait;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication,
        DatabaseTransactions,
        UserTrait,
        CategoryTrait,
        UnitMeasureTrait,
        ProductTrait;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createDefaultsRoles();
        $this->createAdmin();
        $this->createUser();
    }
}
