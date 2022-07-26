<?php

namespace App\PivotModels\Catalog;

use App\PivotModels\PivotBase;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $product_id
 * @property int $category_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 */
class ProductCategory extends PivotBase
{
    protected $collection  = 'catalog_products_categories';

    protected $fillable = [
        'product_id',
        'category_id'
    ];

    protected $casts = [
        'id' => 'integer',
        'product_id' => 'integer',
        'category_id' => 'integer'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public static function create(
        int $productId,
        int $categoryId
    ): self
    {
        $productCategory = new self();

        $productCategory->setProductId($productId);
        $productCategory->setCategoryId($categoryId);

        return $productCategory;
    }

    public function getProductId(): int
    {
        return $this->product_id;
    }

    public function getCategoryId(): int
    {
        return $this->category_id;
    }

    public function setProductId(int $productId): self
    {
        $this->product_id = $productId;
        return $this;
    }

    public function setCategoryId(int $categoryId): self
    {
        $this->category_id = $categoryId;
        return $this;
    }
}
