<?php

namespace App\Models\Catalog;

use Jenssegers\Mongodb\Eloquent\Model;

class Basket extends Model
{
    protected $collection = 'catalog_baskets';

    protected $fillable = [
        //
    ];
}
