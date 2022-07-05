<?php

namespace Database\Seeders;

use App\Models\Catalog\Category;
use App\Models\UnitMeasure;
use App\Models\User\Role;
use App\Models\User\User;
use App\PivotModels\User\UserRole;
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
        $roleAdminId = Role::create('Administrator', 'admin')->saveAndReturnId();
        $roleUserId = Role::create('User', 'user')->saveAndReturnId();

        $adminId = User::create(
            'Admin',
            'admin@example.com',
            '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        )->saveAndReturnId();

        $userId = User::create(
            'Alesha',
            'alesha@example.com',
            '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi'
        )->saveAndReturnId();

        UserRole::create($adminId, $roleAdminId)->save();
        UserRole::create($userId, $roleUserId)->save();


        $categoryFruitId = Category::create(['name' => 'Fruit', 'slug' => 'fruit']);
        $categoryVegetablesId = Category::create(['name' => 'Vegetables', 'slug' => 'vegetables']);
        Category::create(['name' => 'cereals', 'slug' => 'cereals']);

        $unitKg = UnitMeasure::create(['name' => 'Kilogram', 'slug' => 'kg']);
        UnitMeasure::create(['name' => 'Piece', 'slug' => 'piece']);

//        Product::create(
//            'Orange',
//            'Ripe, juicy and the most delicious',
//            19.99,
//            $unitKg->id,
//
//
//            [
//                'name' => 'Orange',
//                'description' => 'Ripe, juicy and the most delicious',
//                'store' => 50,
//                'price' => 19.99,
//                'unit_measure' => $unitKgId,
//                'categories' => [$categoryFruitId]
//            ]);
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
