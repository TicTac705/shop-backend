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
        Role::create('Admin', 'admin')->save();
        Role::create('Manager', 'manager')->save();
        Role::create('User', 'user')->save();

        Category::create('Fruit', 'fruit')->save();
        Category::create('Vegetables', 'vegetables')->save();
        Category::create('Cereals', 'cereals')->save();

        UnitMeasure::create('Kilogram', 'kg')->save();
        UnitMeasure::create('Piece', 'piece')->save();
    }
}
