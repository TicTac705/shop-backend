<?php

namespace App\Dto\Catalog;

use App\Dto\BaseDto;
use App\Dto\User\UserDto;
use App\Models\Catalog\Product;

class ProductDto extends BaseDto
{
    public int $id;
    public string $name;
    public string $description;
    public float $price;
    public int $unit_measure_id;
    public int $store;
    public int $user_id;
    public string $updated_at;
    public string $created_at;

    public ?UserDto $author;

    public function __construct(array $parameters = [])
    {
        parent::__construct($parameters);

        $this->author = new UserDto(Product::find($this->id)->user->toArray());
    }
}
