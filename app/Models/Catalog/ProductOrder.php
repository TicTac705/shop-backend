<?php

namespace App\Models\Catalog;

use App\Models\ModelBase;

class ProductOrder extends ModelBase
{
    protected $collection = 'catalog_order_products';

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'totalPrice'
    ];
}
