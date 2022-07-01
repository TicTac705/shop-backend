<?php

namespace App\Models\Catalog;

use App\Models\ModelBase;

class Order extends ModelBase
{
    protected $collection = 'catalog_orders';

    protected $fillable = [
        'user_id'
    ];
}
