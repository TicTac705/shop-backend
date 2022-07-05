<?php

namespace App\Models\Catalog;

use App\Models\ModelBase;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property float $price
 * @property int $unit_measure_id
 * @property int $store
 * @property int $user_id
 *
 */
class Product extends ModelBase
{
    protected $table = 'catalog_products';

    protected $fillable = [
        'name',
        'description',
        'price',
        'unit_measure_id',
        'store',
        'user_id'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function create(
        string $name,
        string $description,
        float  $price,
        int $unitMeasureId,
        int    $store,
        int $userId
    ): self
    {
        $product = new self();

        $product->setName($name);
        $product->setDescription($description);
        $product->setPrice($price);
        $product->setUnitMeasure($unitMeasureId);
        $product->setStore($store);
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

    public function setUnitMeasure(int $unitMeasureId): self
    {
        $this->unit_measure_id = $unitMeasureId;
        return $this;
    }

    public function setStore(int $store): self
    {
        $this->store = $store;
        return $this;
    }

    public function setUserId(int $userId): self
    {
        $this->user_id = $userId;
        return $this;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
