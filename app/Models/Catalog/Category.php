<?php

namespace App\Models\Catalog;

use App\Models\ModelBase;
use App\PivotModels\Catalog\ProductCategory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property string $name
 * @property string $slug
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 */
class Category extends ModelBase
{
    use HasFactory;

    protected $table = 'catalog_categories';

    protected $fillable = [
        'name',
        'slug'
    ];

    protected $dates = ['created_at', 'updated_at'];

    protected $casts = [
        'name' => 'string',
        'slug' => 'string'
    ];

    protected $touches = ['products'];

    public static function create(
        string $name,
        string $slug
    ): self
    {
        $category = new self();

        $category->setSlug($slug);
        $category->setName($name);

        return $category;
    }

    public function getName():string
    {
        return $this->name;
    }

    public function getSlug():string
    {
        return $this->slug;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setSlug(string $slug):self
    {
        $this->slug = $slug;
        return $this;
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'catalog_products_categories')->withTimestamps()->using(ProductCategory::class);
    }
}
