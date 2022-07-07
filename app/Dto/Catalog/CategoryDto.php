<?php
namespace App\Dto\Catalog;

use App\Dto\BaseDto;
use App\Models\Catalog\Category;

class CategoryDto extends BaseDto
{
    public int $id;
    public string $name;
    public string $slug;
    public int $updatedAt;
    public int $createdAt;

    public static function fromModel(Category $category): self
    {
        return new self([
            'id' => $category->id,
            'name' => $category->name,
            'slug' => $category->slug,
            'updatedAt' => $category->updated_at->timestamp,
            'createdAt' => $category->created_at->timestamp,
        ]);
    }
}
