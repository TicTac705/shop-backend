<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\Model;

class ProductBasket extends Model
{
    use HasFactory;

    protected $collection = 'basket_product';

    protected $fillable = [
        'basket_id',
        'product_id',
        'quantity'
    ];
}
