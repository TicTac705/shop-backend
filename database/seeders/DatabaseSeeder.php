<?php

namespace Database\Seeders;

use App\Models\Catalog\Basket;
use App\Models\Catalog\Category;
use App\Models\Catalog\Product;
use App\Models\UnitMeasure;
use App\Models\User\Role;
use App\Models\User\User;
use Faker\Generator;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $roles = Role::factory()->count(3)->state(new Sequence(
            ['name' => 'Admin', 'slug' => 'admin'],
            ['name' => 'Manager', 'slug' => 'manager'],
            ['name' => 'User', 'slug' => 'user']
        ))->create();

        foreach ($roles as $role) {
            User::factory()->count(3)->hasAttached($role)->create();
        }

        $users = User::factory()->count(3)->hasAttached($roles)->create();


        $categories = Category::factory()->count(3)->state(new Sequence(
            ['name' => 'Fruit', 'slug' => 'fruit'],
            ['name' => 'Vegetables', 'slug' => 'vegetables'],
            ['name' => 'Cereals', 'slug' => 'cereals']
        ))->create();

        $unitMeasures = UnitMeasure::factory()->count(2)->state(new Sequence(
            ['name' => 'Kilogram', 'slug' => 'kg'],
            ['name' => 'Piece', 'slug' => 'piece']
        ))->create();

        foreach ($unitMeasures as $unitMeasure) {
            Product::factory()->count(10)->for($unitMeasure)->hasAttached($categories)->create();
        }

        $products = Product::factory()->count(10)->for($unitMeasures->first())->hasAttached($categories)->create();

        Basket::factory()->for($users->random()->first())->hasAttached($products, ['count' => (new Generator)->randomNumber()])->create();
    }
}
