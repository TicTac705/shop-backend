<?php

namespace App\Services\Catalog;

use App\Models\Catalog\Category;

class CategoryService
{
    /**
     * @return Category[]
     */
    public function getAll(): array
    {
        return Category::all()->all();
    }
}
