<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDtoCollection;
use App\Models\Catalog\Category;

class CategoryDtoCollection extends BaseDtoCollection
{

    /**
     * @param Category[] $data
     */
    public function __construct(array $data)
    {
        $collection = array_map(fn(Category $item):CategoryDto => CategoryDto::fromModel($item), $data);

        parent::__construct($collection);
    }
}
