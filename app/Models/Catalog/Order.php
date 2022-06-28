<?php

namespace App\Models\Catalog;

use Jenssegers\Mongodb\Eloquent\Model;

class Order extends Model
{
    protected $collection = 'catalog_orders';

    protected $fillable = [
        'user_id'
    ];
}
