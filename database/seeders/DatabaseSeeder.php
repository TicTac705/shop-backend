<?php

namespace Database\Seeders;

use App\Models\Catalog\Basket;
use App\Models\Catalog\Category;
use App\Models\Catalog\Order;
use App\Models\Catalog\Product;
use App\Models\UnitMeasure;
use App\Models\User\Role;
use App\Models\User\User;
use App\PivotModels\Catalog\BasketProduct;
use App\PivotModels\Catalog\OrderProduct;
use Exception;
use Illuminate\Database\Eloquent\Factories\Sequence;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * @throws Exception
     */
    public function run(): void
    {
        $adminRoleId = Role::create('Admin', 'admin')->saveAndReturnId();
        $managerRoleId = Role::create('Manager', 'manager')->saveAndReturnId();
        $userRoleId = Role::create('User', 'user')->saveAndReturnId();

        $fruitId = Category::create('Fruit', 'fruit')->saveAndReturnId();
        $vegetablesId = Category::create('Vegetables', 'vegetables')->saveAndReturnId();
        $cerealsId = Category::create('Cereals', 'cereals')->saveAndReturnId();

        $kgId = UnitMeasure::create('Kilogram', 'kg')->saveAndReturnId();
        $pieceId = UnitMeasure::create('Piece', 'piece')->saveAndReturnId();

        /** @var User[] $users */
        $users = User::factory()->count(3)->state(new Sequence(
            ['role_ids' => [$adminRoleId], 'email' => 'admin@shop.local'],
            ['role_ids' => [$managerRoleId], 'email' => 'manager@shop.local'],
            ['role_ids' => [$userRoleId], 'email' => 'user@shop.local']
        ))->create();

        /** @var User $superUser */
        $superUser = User::factory()->state(new Sequence(
            ['role_ids' => [$adminRoleId, $managerRoleId, $userRoleId], 'email' => 'super-user@shop.local']
        ))->create();

        /** @var Product[] $products */
        $products = Product::factory()->count(100)->state(new Sequence(
            ['unit_measure_id' => $kgId, 'category_ids' => [$fruitId, $cerealsId], 'user_id' => $superUser->getId()],
            ['unit_measure_id' => $pieceId, 'category_ids' => [$vegetablesId, $cerealsId], 'user_id' => $superUser->getId()],
        ))->create();

        $positionsBasket = [];
        $positionsOrder = [];
        foreach ($products as $product) {
            if (!$product->getIsActive()) {
                continue;
            }

            $count = random_int(1,10);

            $positionsBasket[] = BasketProduct::fromArray(
                [
                    'productId' => $product->getId(),
                    'count' => $count
                ]
            );

            $positionsOrder[] = OrderProduct::fromArray(
                [
                    'productId' => $product->getId(),
                    'price' => $product->getPrice(),
                    'count' => $count
                ]
            );
        }

        Basket::factory()->count(2)->state(new Sequence(
            ['user_id' => $superUser->getId(), 'positions' => $positionsBasket],
            ['user_id' => $users[2]->getId(), 'positions' => $positionsBasket],
        ))->create();

        Order::factory()->state(new Sequence(
            [
                'user_id' => $superUser->getId(),
                'user_name' => $superUser->getName(),
                'user_email' => $superUser->getEmail(),
                'positions' => $positionsOrder
            ]
        ))->create();
    }
}
