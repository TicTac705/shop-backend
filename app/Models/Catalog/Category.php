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

    public function checkBySlug(string $slug): bool
    {
        return Category::where('slug', $slug)->exists();
    }

    public function getIdBySlug(string $slug): string
    {
        return Category::where('slug', $slug)->first()->id;
    }


}
