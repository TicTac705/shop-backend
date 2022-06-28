<?php

namespace App\Models\Catalog;

use Jenssegers\Mongodb\Eloquent\Model;

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
}
