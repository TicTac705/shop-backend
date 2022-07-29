<?php

namespace App\PivotModels\Catalog;

use App\Models\Catalog\Product;
use App\PivotModels\PivotBase;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property string $order_id
 * @property string $product_id
 * @property float $price
 * @property int $count
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 */
class OrderProduct extends PivotBase
{
    protected $collection = 'catalog_order_product';

    protected $fillable = [
        'order_id',
        'product_id',
        'price',
        'count'
    ];

    protected $casts = [
        'id' => 'string',
        'order_id' => 'string',
        'product_id' => 'string',
        'price' => 'float',
        'count' => 'integer',
    ];

    protected $dates = ['created_at', 'updated_at'];

    public static function create(
        string $orderId,
        string $productId,
        float  $price,
        int    $count
    ): self
    {
        $orderProduct = new self();

        $orderProduct->setOrderId($orderId);
        $orderProduct->setProductId($productId);
        $orderProduct->setPrice($price);
        $orderProduct->setCount($count);

        return $orderProduct;
    }

    public function getOrderId(): string
    {
        return $this->order_id;
    }

    public function getProductId(): string
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

    public function setOrderId(string $orderId): self
    {
        $this->order_id = $orderId;
        return $this;
    }

    public function setProductId(string $productId): self
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

    public function product()
    {
        return Product::query()->where('_id', '=', $this->getProductId())->get();
    }
}
