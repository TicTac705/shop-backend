<?php

namespace App\Models\Catalog;

use App\Models\ModelBase;

class Category extends ModelBase
{
    protected $table = 'catalog_categories';

    protected $fillable = [
        'name',
        'slug'
    ];

    protected $dates = ['created_at', 'updated_at'];
}
