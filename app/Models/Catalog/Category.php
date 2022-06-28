<?php

namespace App\Models\Catalog;

use Jenssegers\Mongodb\Eloquent\Model;

class Category extends Model
{
    protected $collection = 'catalog_categories';

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
