<?php

namespace App\PivotModels\Catalog;

use App\Models\Catalog\Product;
use App\PivotModels\PivotBase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $basket_id
 * @property int $product_id
 * @property int $count
 * @property float $price
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 */
class BasketProduct extends PivotBase
{
    protected $table = 'catalog_baskets_products';

    protected $fillable = [
        'basket_id',
        'product_id',
        'count',
        'price',
    ];

    protected $casts = [
        'id' => 'integer',
        'basket_id' => 'integer',
        'product_id' => 'integer',
        'count' => 'integer',
        'price' => 'float',
    ];

    protected $dates = ['created_at', 'updated_at'];

    public static function create(
        int $basketId,
        int $productId,
        int $count,
        float $price
    ): self
    {
        $productCategory = new self();

        $productCategory->setBasketId($basketId);
        $productCategory->setProductId($productId);
        $productCategory->setCount($count);
        $productCategory->setPrice($price);

        return $productCategory;
    }

    public function getBasketId(): int
    {
        return $this->basket_id;
    }

    public function getProductId(): int
    {
        return $this->product_id;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setBasketId(int $basketId): self
    {
        $this->basket_id = $basketId;
        return $this;
    }

    public function setProductId(int $productId): self
    {
        $this->product_id = $productId;
        return $this;
    }

    public function setCount(int $count): self
    {
        $this->count = $count;
        return $this;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
