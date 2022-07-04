<?php

namespace Database\Seeders;

use App\Models\Catalog\Category;
use App\Models\UnitMeasure;
use App\Models\User\UserRole;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $roleAdminId = UserRole::create([
            'name' => 'Administrator',
            'slug' => 'admin'
        ]);

        $roleUserId = UserRole::create([
            'name' => 'User',
            'slug' => 'user'
        ]);

        $categoryFruitId = Category::create(['name' => 'Fruit', 'slug' => 'fruit']);
        $categoryVegetablesId = Category::create(['name' => 'Vegetables', 'slug' => 'vegetables']);
        Category::create(['name' => 'cereals', 'slug' => 'cereals']);

        $unitKgId = UnitMeasure::create(['name' => 'Kilogram', 'slug' => 'kg']);
        UnitMeasure::create(['name' => 'Piece', 'slug' => 'piece']);

//        Product::create([
//            'name' => 'Orange',
//            'description' => 'Ripe, juicy and the most delicious',
//            'store' => 50,
//            'price' => 19.99,
//            'unit_measure' => $unitKgId,
//            'categories' => [$categoryFruitId]
//        ]);
//
//        Product::create([
//            'name' => 'Apple',
//            'description' => 'Ripe, juicy and the most delicious',
//            'store' => 90,
//            'price' => 11.02,
//            'unit_measure' => $unitKgId,
//            'categories' => [$categoryFruitId]
//        ]);
//
//        Product::create([
//            'name' => 'Millet',
//            'description' => 'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
//            'store' => 90,
//            'price' => 11.02,
//            'unit_measure' => $unitKgId,
//            'categories' => [$categoryVegetablesId]
//        ]);
    }
}
