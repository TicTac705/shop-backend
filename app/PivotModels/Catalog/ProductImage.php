<?php

namespace App\PivotModels\Catalog;

use App\PivotModels\PivotBase;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property string $product_id
 * @property string $image_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 */
class ProductImage extends PivotBase
{
    protected $collection  = 'catalog_products_images';

    protected $fillable = [
        'product_id',
        'image_id'
    ];

    protected $casts = [
        'id' => 'string',
        'product_id' => 'string',
        'image_id' => 'string'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public static function create(
        string $productId,
        string $imageId
    ): self
    {
        $productImage = new self();

        $productImage->setProductId($productId);
        $productImage->setImageId($imageId);

        return $productImage;
    }

    public function getUserId(): string
    {
        return $this->user_id;
    }

    public function getRoleId(): string
    {
        return $this->role_id;
    }

    public function setProductId(string $productId): self
    {
        $this->product_id = $productId;
        return $this;
    }

    public function setImageId(string $imageId): self
    {
        $this->image_id = $imageId;
        return $this;
    }
}
