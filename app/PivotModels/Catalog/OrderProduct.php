<?php

namespace App\PivotModels\Catalog;

use App\Models\Catalog\Product;
use App\PivotModels\PivotBase;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $order_id
 * @property int $product_id
 * @property float $price
 * @property int $count
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 */
class OrderProduct extends PivotBase
{
    protected $collection  = 'catalog_order_product';

    protected $fillable = [
        'order_id',
        'product_id',
        'price',
        'count'
    ];

    protected $casts = [
        'id' => 'integer',
        'order_id' => 'integer',
        'product_id' => 'integer',
        'price' => 'float',
        'count' => 'integer',
    ];

    protected $dates = ['created_at', 'updated_at'];

    public static function create(
        int   $orderId,
        int   $productId,
        float $price,
        int   $count
    ): self
    {
        $orderProduct = new self();

        $orderProduct->setOrderId($orderId);
        $orderProduct->setProductId($productId);
        $orderProduct->setPrice($price);
        $orderProduct->setCount($count);

        return $orderProduct;
    }

    public function getOrderId(): int
    {
        return $this->order_id;
    }

    public function getProductId(): int
    {
        return $this->product_id;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function setOrderId(int $orderId): self
    {
        $this->order_id = $orderId;
        return $this;
    }

    public function setProductId(int $productId): self
    {
        $this->product_id = $productId;
        return $this;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function setCount(int $count): self
    {
        $this->count = $count;
        return $this;
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class);
    }
}
