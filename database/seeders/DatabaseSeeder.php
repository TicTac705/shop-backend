<?php

namespace Database\Seeders;

use App\Models\Catalog\Category;
use App\Models\Catalog\Product;
use App\Models\UnitMeasure;
use App\Models\User\Role;
use App\Models\User\User;
use App\PivotModels\Catalog\ProductCategory;
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


        $categoryFruitId = Category::create('Fruit', 'fruit')->saveAndReturnId();
        $categoryVegetablesId = Category::create('Vegetables', 'vegetables')->saveAndReturnId();
        Category::create('Cereals', 'cereals')->save();

        $unitKgId = UnitMeasure::create('Kilogram', 'kg')->saveAndReturnId();
        UnitMeasure::create('Piece', 'piece')->save();

        $orangeID = Product::create(
            'Orange',
            'Ripe, juicy and the most delicious',
            49.99,
            $unitKgId,
            500,
            $adminId
        )->saveAndReturnId();

        $appleId = Product::create(
            'Apple',
            'Ripe, juicy and the most delicious',
            60.9,
            $unitKgId,
            500,
            $adminId
        )->saveAndReturnId();

        $milletId = Product::create(
            'Millet',
            'Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.',
            30.5,
            $unitKgId,
            500,
            $adminId
        )->saveAndReturnId();

        ProductCategory::create($orangeID, $categoryFruitId)->save();
        ProductCategory::create($appleId, $categoryFruitId)->save();
        ProductCategory::create($milletId, $categoryVegetablesId)->save();
    }
}
