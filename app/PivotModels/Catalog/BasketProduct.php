<?php

namespace App\PivotModels\Catalog;

use App\Models\Catalog\Basket;
use App\Models\Catalog\Product;
use App\PivotModels\PivotBase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $basket_id
 * @property int $product_id
 * @property int $count
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
        'count'
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
        int $count
    ): self
    {
        $productCategory = new self();

        $productCategory->setBasketId($basketId);
        $productCategory->setProductId($productId);
        $productCategory->setCount($count);

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

    public function basket(): BelongsTo
    {
        return $this->belongsTo(Basket::class)->withTimestamps();
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
