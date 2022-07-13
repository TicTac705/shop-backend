<?php
namespace App\Dto\Catalog;

use App\Dto\BaseDto;
use App\Models\Catalog\Category;

class CategoryDto extends BaseDto
{
    public int $id;
    public string $name;
    public string $slug;
    public ?int $updatedAt;
    public ?int $createdAt;

    public static function fromModel(Category $category): self
    {
        return new self([
            'id' => $category->getId(),
            'name' => $category->getName(),
            'slug' => $category->getSlug(),
            'updatedAt' => $category->getUpdatedAtTimestamp(),
            'createdAt' => $category->getCreatedAtTimestamp(),
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
