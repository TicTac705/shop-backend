<?php

namespace App\Mappers\Catalog;

use App\Dto\Catalog\CategoryDtoCollection;
use App\Dto\ImageDtoCollection;
use App\Models\Catalog\Category;
use App\Models\Image;
use Illuminate\Support\Collection;

trait ProductDtoMapper
{

    /**
     * @param Category[] $data
     * @return Collection
     */
    public function fromModelsToCollectionForCategories(array $data): Collection
    {
        $categoriesDto = new CategoryDtoCollection($data);
        $categoryCollection = collect($categoriesDto->toArray());

        return $categoryCollection->map(fn($category) => collect($category)->only(['id', 'name'])->all());
    }

    /**
     * @param Image[] $data
     * @return Collection
     */
    public function fromModelsToCollectionForImages(array $data): Collection
    {
        $imagesDto = new ImageDtoCollection($data);
        $imageCollection = collect($imagesDto->toArray());

        return $imageCollection->map(fn($image) => collect($image)->only(['id', 'name', 'nameOriginal', 'src', 'size'])->all());
    }
}
