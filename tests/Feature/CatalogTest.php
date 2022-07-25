<?php

namespace Tests\Feature;

use App\Dto\Catalog\CategoryLightDto;
use App\Dto\Catalog\ProductDto;
use App\Models\Catalog\Category;
use App\Models\Catalog\Product;
use App\Models\UnitMeasure;
use Illuminate\Foundation\Testing\RefreshDatabase;
use JWTAuth;
use Tests\TestCase;

class CatalogTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        $this->createDefaultsCategories();
        $this->createDefaultsUnitMeasures();
    }

    public function testDirectoryListing(): void
    {
        $this->createDefaultsProducts();

        $this->authorize($this->admin->getEmail(), $this->defaultPassword);

        $response = $this->getJson(route('home'));

        $response->assertOk();
        $this->assertAuthenticated();

        $this->assertNotEmpty($response->original->collection);
        $this->assertNotEmpty($response->original->paginate);

        $this->assertTrue($response->original->paginate['lastPage'] > 0);
        $this->assertTrue($response->original->paginate['currentPage'] > 0);
        $this->assertTrue($response->original->paginate['totalElements'] > 0);

        foreach ($response->original->collection as $item) {
            $this->assertTrue($item instanceof ProductDto);
        }
    }

    public function testCreateProduct(): void
    {
        $this->authorize($this->admin->getEmail(), $this->defaultPassword);

        $categoryIds = [];
        foreach ($this->categories as $category) {
            /** @var Category $category */
            $categoryIds[] = $category->getId();
        }

        /** @var UnitMeasure $unitMeasure */
        $unitMeasure = $this->unitMeasures->random()->getId();

        $response = $this->postJson(route('profile.catalogManagement.products.store'), [
            "is_active" => true,
            "name" => "Test",
            "description" => "Lorem",
            "price" => 777,
            "unit_measure_id" => $unitMeasure,
            "store" => 190,
            "categories" => $categoryIds
        ]);

        $response->assertSuccessful();
        $this->assertAuthenticated();

        $this->assertTrue($response->original instanceof ProductDto);

        /** @var ProductDto $product */
        $product = $response->original;

        $this->assertIsBool($product->isActive);
        $this->assertNotNull($product->name);
        $this->assertNotNull($product->description);
        $this->assertNotNull($product->price);
    }

    public function testEditProduct(): void
    {
        $this->authorize($this->admin->getEmail(), $this->defaultPassword);

        /** @var Product $product */
        $product = Product::factory()->for($this->unitMeasures->first())->hasAttached($this->categories->first())->create();

        $response = $this->putJson(route('profile.catalogManagement.products.update', ['id' => $product->getId()]), [
            "is_active" => false,
            "name" => "Test123",
            "description" => "Lorem",
            "price" => 777.999,
            "store" => 999,
            "categories" => [$this->categories->first()->getId()]
        ]);

        $response->assertOk();
        $this->assertAuthenticated();

        /** @var ProductDto $editedProduct */
        $editedProduct = $response->original;

        $this->assertFalse($editedProduct->isActive);
        $this->assertEquals('Test123', $editedProduct->name);
        $this->assertEquals('Lorem', $editedProduct->description);
        $this->assertEquals(777.999, $editedProduct->price);
        $this->assertEquals(999, $editedProduct->store);
        $this->assertEquals([CategoryLightDto::fromModel($this->categories->first())], $editedProduct->categories);
    }

    public function testProductRemoval(): void
    {
        $this->authorize($this->admin->getEmail(), $this->defaultPassword);

        /** @var Product $product */
        $product = Product::factory()->for($this->unitMeasures->first())->hasAttached($this->categories->first())->create();

        $response = $this->deleteJson(route('profile.catalogManagement.products.destroy', ['id' => $product->getId()]));

        $response->assertOk();
        $this->assertAuthenticated();

        $this->assertSoftDeleted($product);
    }

    private function authorize(string $email, string $password): void
    {
        $token = JWTAuth::attempt(['email' => $email, 'password' => $password]);
        $this->defaultHeaders = ['Authorization' => "Bearer $token"];
    }
}
