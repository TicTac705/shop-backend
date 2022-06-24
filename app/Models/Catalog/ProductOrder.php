<?php

namespace App\Models\Catalog;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductOrder extends Model
{
    use HasFactory;

    protected $collection = 'order_product';

    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'totalPrice'
    ];
}
