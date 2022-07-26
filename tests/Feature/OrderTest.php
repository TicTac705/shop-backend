<?php

namespace Tests\Feature;

use App\Dto\Catalog\OrderDto;
use App\Helpers\Statuses\Order\DeliveryStatuses;
use App\Helpers\Statuses\Order\OrderStatuses;
use App\Models\Catalog\Basket;
use App\Models\Catalog\Order;
use Faker\Factory;
use Faker\Generator;
use Illuminate\Foundation\Testing\RefreshDatabase;
use JWTAuth;
use Tests\TestCase;

class OrderTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var Generator
     */
    private static $faker;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createDefaultsCategories();
        $this->createDefaultsUnitMeasures();
        $this->createDefaultsProducts();

        self::$faker = Factory::create('Ru_RU');
    }

    public function testOrderEmptyList(): void
    {
        $this->authorize($this->admin->getEmail(), $this->defaultPassword);

        $response = $this->getJson(route('profile.orders.getList'));
        $response->assertOk();
        $this->assertAuthenticated();
        $this->assertEmpty($response->original);
    }

    public function testCreateOrder(): void
    {
        /** @var Basket $basket */
        $basket = Basket::factory()->for($this->admin)->hasAttached($this->products, ['count' => self::$faker->randomNumber()])->create();

        $this->authorize($this->admin->getEmail(), $this->defaultPassword);

        $response = $this->postJson(route('profile.orders.create'), [
            'basket_id' => $basket->getId(),
            'delivery_id' => DeliveryStatuses::COURIER_DELIVERY,
            'delivery_address' => self::$faker->streetAddress,
        ]);
        $response->assertSuccessful();
        $this->assertAuthenticated();

        /** @var OrderDto $order */
        $order = $response->original;

        $this->assertEquals($this->admin->getId(), $order->userId);
        $this->assertEquals($this->admin->getName(), $order->userName);
        $this->assertEquals($this->admin->getEmail(), $order->userEmail);
        $this->assertEquals(DeliveryStatuses::COURIER_DELIVERY, $order->deliveryId);
        $this->assertNotEmpty($order->deliveryAddress);
        $this->assertCount($this->products->count(), $order->items);
    }

    public function testRecallOrder(): void
    {
        /** @var Basket $basket */
        $basket = Basket::factory()->for($this->admin)->hasAttached($this->products, ['count' => self::$faker->randomNumber()])->create();

        $this->authorize($this->admin->getEmail(), $this->defaultPassword);

        $response = $this->postJson(route('profile.orders.create'), [
            'basket_id' => $basket->getId(),
            'delivery_id' => DeliveryStatuses::COURIER_DELIVERY,
            'delivery_address' => self::$faker->streetAddress,
        ]);
        $response->assertSuccessful();
        $this->assertAuthenticated();

        /** @var OrderDto $order */
        $order = $response->original;

        $response= $this->putJson(route('profile.orders.recall', ['id' => $order->id]));
        $response->assertOk();

        /** @var Order $modifiedOrder */
        $modifiedOrder = Order::query()->findOrFail($order->id);
        $this->assertEquals(OrderStatuses::CANCELED, $modifiedOrder->getOrderStatusId());
    }

    private function authorize(string $email, string $password): void
    {
        $token = JWTAuth::attempt(['email' => $email, 'password' => $password]);
        $this->defaultHeaders = ['Authorization' => "Bearer $token"];
    }
}
