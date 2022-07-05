<?php

namespace App\PivotModels\Catalog;

use App\PivotModels\PivotBase;

/**
 * @property int $id
 * @property int $product_id
 * @property int $category_id
 */
class ProductCategory extends PivotBase
{
    protected $table = 'catalog_products_categories';

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
        $userRole = new self();

        $userRole->setProductId($productId);
        $userRole->setCategoryId($categoryId);

        return $userRole;
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

    public function setCategoryId(int $categoryId): self
    {
        $this->category_id = $categoryId;
        return $this;
    }
}
