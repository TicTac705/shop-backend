<?php

namespace Tests\Feature;

use App\Dto\Catalog\BasketDto;
use App\Dto\Catalog\BasketItemDto;
use App\Models\Catalog\Product;
use Illuminate\Foundation\Testing\RefreshDatabase;
use JWTAuth;
use Tests\TestCase;

class BasketTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createDefaultsCategories();
        $this->createDefaultsUnitMeasures();
    }

    public function testBasket(): void
    {
        $this->authorize($this->admin->getEmail(), $this->defaultPassword);

        $response = $this->getJson(route('basket.getBasket'));
        $response->assertOk();
        $this->assertAuthenticated();

        /** @var BasketDto $basket */
        $basket = $response->original;

        $this->assertEmpty($basket->items);
        $this->assertEquals(0, $basket->totalCount);
    }

    public function testAddingProductToBasket(): void
    {
        /** @var Product $product */
        $product = Product::factory()->for($this->unitMeasures->first())->hasAttached($this->categories->first())->create();

        $this->authorize($this->admin->getEmail(), $this->defaultPassword);

        $response = $this->postJson(route('basket.product.store'), ['product_id' => $product->getId()]);
        $response->assertOk();
        $this->assertAuthenticated();

        /** @var BasketItemDto $basketItem */
        $basketItem = $response->original;

        $this->assertEquals(1, $basketItem->count);

        $response = $this->getJson(route('basket.getBasket'));
        $response->assertOk();

        /** @var BasketDto $basket */
        $basket = $response->original;

        $this->assertNotEmpty($basket->items);
        $this->assertEquals(1, $basket->totalCount);
    }

    public function testUpdateProductBasket(): void
    {
        /** @var Product $product */
        $product = Product::factory()->for($this->unitMeasures->first())->hasAttached($this->categories->first())->create();

        $this->authorize($this->admin->getEmail(), $this->defaultPassword);

        $response = $this->postJson(route('basket.product.store'), ['product_id' => $product->getId()]);
        $response->assertOk();
        $this->assertAuthenticated();

        $response = $this->putJson(route('basket.product.update'), [
            'product_id' => $product->getId(),
            'quantity' => 77
        ]);
        $response->assertOk();

        /** @var BasketItemDto $basketItem */
        $basketItem = $response->original;

        $this->assertEquals(77, $basketItem->count);
    }

    public function testDeleteProductBasket(): void
    {
        /** @var Product $product */
        $product = Product::factory()->for($this->unitMeasures->first())->hasAttached($this->categories->first())->create();

        $this->authorize($this->admin->getEmail(), $this->defaultPassword);

        $response = $this->postJson(route('basket.product.store'), ['product_id' => $product->getId()]);
        $response->assertOk();
        $this->assertAuthenticated();

        $response = $this->deleteJson(route('basket.product.destroy', ['id' => $product->getId()]));
        $response->assertOk();

        $response = $this->getJson(route('basket.getBasket'));
        $response->assertOk();

        /** @var BasketDto $basket */
        $basket = $response->original;

        $this->assertEmpty($basket->items);
        $this->assertEquals(0, $basket->totalCount);
    }

    private function authorize(string $email, string $password): void
    {
        $token = JWTAuth::attempt(['email' => $email, 'password' => $password]);
        $this->defaultHeaders = ['Authorization' => "Bearer $token"];
    }
}
