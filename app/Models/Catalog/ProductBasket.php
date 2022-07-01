<?php

namespace App\Models\Catalog;

use App\Models\ModelBase;

class ProductBasket extends ModelBase
{
    protected $collection = 'catalog_basket_products';

    protected $fillable = [
        'basket_id',
        'product_id',
        'quantity'
    ];
}
