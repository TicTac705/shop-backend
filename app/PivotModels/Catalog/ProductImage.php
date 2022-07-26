<?php

namespace App\PivotModels\Catalog;

use App\PivotModels\PivotBase;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $product_id
 * @property int $image_id
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
        'id' => 'integer',
        'product_id' => 'integer',
        'image_id' => 'integer'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public static function create(
        int $productId,
        int $imageId
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

    public function setProductId(int $productId): self
    {
        $this->product_id = $productId;
        return $this;
    }

    public function setImageId(int $imageId): self
    {
        $this->image_id = $imageId;
        return $this;
    }
}
