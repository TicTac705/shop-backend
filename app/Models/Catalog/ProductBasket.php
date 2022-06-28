<?php

namespace App\Models\Catalog;

use Jenssegers\Mongodb\Eloquent\Model;

class ProductBasket extends Model
{
    protected $collection = 'catalog_basket_products';

    protected $fillable = [
        'basket_id',
        'product_id',
        'quantity'
    ];
}
