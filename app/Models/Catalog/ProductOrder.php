<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    protected $collection = 'catalog_order_products';

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'totalPrice'
    ];
}
