<?php

namespace App\PivotModels\Catalog;

use App\PivotModels\PivotBase;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property string $basket_id
 * @property string $product_id
 * @property int $count
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 */
class BasketProduct extends PivotBase
{
    protected $collection  = 'catalog_baskets_products';

    protected $fillable = [
        'basket_id',
        'product_id',
        'count'
    ];

    protected $casts = [
        'id' => 'string',
        'basket_id' => 'string',
        'product_id' => 'string',
        'count' => 'integer',
        'price' => 'float',
    ];

    protected $dates = ['created_at', 'updated_at'];

    public static function create(
        string $basketId,
        string $productId,
        int $count
    ): self
    {
        $productCategory = new self();

        $productCategory->setBasketId($basketId);
        $productCategory->setProductId($productId);
        $productCategory->setCount($count);

        return $productCategory;
    }

    public function getBasketId(): string
    {
        return $this->basket_id;
    }

    public function getProductId(): string
    {
        return $this->product_id;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function setBasketId(string $basketId): self
    {
        $this->basket_id = $basketId;
        return $this;
    }

    public function setProductId(string $productId): self
    {
        $this->product_id = $productId;
        return $this;
    }

    public function setCount(int $count): self
    {
        $this->count = $count;
        return $this;
    }
}
