<?php

namespace App\Models\Catalog;

use App\Models\ModelBase;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property string $name
 * @property string $description
 * @property float $price
 * @property string $unit_measure_id
 * @property int $store
 * @property string $user_id
 * @property bool $is_active
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property null|Carbon $deleted_at
 *
 */
class Product extends ModelBase
{
    use HasFactory, SoftDeletes;

    protected $collection = 'catalog_products';

    protected $fillable = [
        'name',
        'description',
        'price',
        'unit_measure_id',
        'store',
        'user_id'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    public function create(
        string $name,
        string $description,
        float  $price,
        string $unitMeasureId,
        int    $store,
        string $userId,
        bool   $isActive
    ): self
    {
        $product = new self();

        $product->setName($name);
        $product->setDescription($description);
        $product->setPrice($price);
        $product->setUnitMeasureId($unitMeasureId);
        $product->setStore($store);
        $product->setUserId($userId);
        $product->setIsActive($isActive);

        return $product;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getUnitMeasureId(): string
    {
        return $this->unit_measure_id;
    }

    public function getStore(): int
    {
        return $this->store;
    }

    public function getUserId(): string
    {
        return $this->user_id;
    }

    public function getIsActive(): bool
    {
        return $this->is_active;
    }

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

    public function setUnitMeasureId(string $unitMeasureId): self
    {
        $this->unit_measure_id = $unitMeasureId;
        return $this;
    }

    public function setStore(int $store): self
    {
        $this->store = $store;
        return $this;
    }

    public function setUserId(string $userId): self
    {
        $this->user_id = $userId;
        return $this;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->is_active = $isActive;
        return $this;
    }
}
