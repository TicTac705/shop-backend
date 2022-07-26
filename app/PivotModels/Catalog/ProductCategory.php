<?php

namespace App\PivotModels\Catalog;

use App\PivotModels\PivotBase;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property string $product_id
 * @property string $category_id
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
        'id' => 'string',
        'product_id' => 'string',
        'category_id' => 'string'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public static function create(
        string $productId,
        string $categoryId
    ): self
    {
        $productCategory = new self();

        $productCategory->setProductId($productId);
        $productCategory->setCategoryId($categoryId);

        return $productCategory;
    }

    public function getProductId(): string
    {
        return $this->product_id;
    }

    public function getCategoryId(): string
    {
        return $this->category_id;
    }

    public function setProductId(string $productId): self
    {
        $this->product_id = $productId;
        return $this;
    }

    public function setCategoryId(string $categoryId): self
    {
        $this->category_id = $categoryId;
        return $this;
    }
}
