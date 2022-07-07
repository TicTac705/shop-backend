<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDto;

class ProductUpdateDto extends BaseDto
{
    public int $id;
    public string $name;
    public string $description;
    public int $price;
    public int $unitMeasureId;
    public int $store;
    public ?array $pictures;
    public array $categories;
}
