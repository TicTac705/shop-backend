<?php

namespace App\Models\Catalog;

use Jenssegers\Mongodb\Eloquent\Model;

/**
 * @property string $id
 * @property string $name
 * @property int $store
 * @property float $price
 * @property array<string> $categories
 *
 */
class Product extends Model
{
    protected $collection = 'catalog_products';

    protected $fillable = [
        'name',
        'description',
        'store',
        'price',
        'categories',
        'pictures'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function categories()
    {
        return $this->hasMany(Item::class);
    }
}
