<?php

namespace App\Models\Catalog;

use App\Models\ModelBase;

/**
 * @property string $id
 * @property string $name
 * @property string $description
 * @property float $price
 * @property string $unit_measure
 * @property int $store
 * @property null|array<string> $pictures
 * @property array<string> $categories
 * @property string $user_id
 *
 */
class Product extends ModelBase
{
    protected $table = 'catalog_products';

    protected $fillable = [
        'name',
        'description',
        'price',
        'unit_measure',
        'store',
        'pictures',
        'categories',
        'user_id'
    ];

    protected $dates = ['created_at', 'updated_at'];

    protected $casts = [
        'pictures' => 'array',
        'categories' => 'array',
    ];

    public function create(
        string $name,
        string $description,
        float  $price,
        string $unitMeasure,
        int    $store,
        array  $pictures,
        array  $categories,
        string $userId
    ): self
    {
        $product = new self();

        $product->setName($name);
        $product->setDescription($description);
        $product->setPrice($price);
        $product->setUnitMeasure($unitMeasure);
        $product->setStore($store);
        $product->setPictures($pictures);
        $product->setCategories($categories);
        $product->setUserId($userId);

        return $product;
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /*...*/

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function setUnitMeasure(string $unitMeasure): self
    {
        $this->unit_measure = $unitMeasure;
        return $this;
    }

    public function setStore(int $store): self
    {
        $this->store = $store;
        return $this;
    }

    public function setPictures(array $pictures): self
    {
        $this->pictures = $pictures;
        return $this;
    }

    public function setCategories(array $categories): self
    {
        $this->categories = $categories;
        return $this;
    }

    public function setUserId(string $userId): self
    {
        $this->user_id = $userId;
        return $this;
    }

}
