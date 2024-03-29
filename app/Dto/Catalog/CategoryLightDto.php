<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDto;
use App\Models\Catalog\Category;

class CategoryLightDto extends BaseDto
{
    public string $id;
    public string $name;

    public static function fromModel(Category $category): self
    {
        return new self([
            'id' => $category->getId(),
            'name' => $category->getName()
        ]);
    }

    /**
     * @param Category[] $items
     * @return self[]
     */
    public function fromList(array $items): array
    {
        return array_map(fn(Category $item): self => self::fromModel($item), $items);
    }
}
