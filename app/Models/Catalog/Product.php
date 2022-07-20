<?php

namespace App\Models\Catalog;

use App\Models\Image;
use App\Models\ModelBase;
use App\Models\UnitMeasure;
use App\Models\User\User;
use App\PivotModels\Catalog\ProductCategory;
use App\PivotModels\Catalog\ProductImage;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $name
 * @property string $description
 * @property float $price
 * @property int $unit_measure_id
 * @property int $store
 * @property int $user_id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 */
class Product extends ModelBase
{
    use HasFactory;

    protected $table = 'catalog_products';

    protected $fillable = [
        'name',
        'description',
        'price',
        'unit_measure_id',
        'store',
        'user_id'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function create(
        string $name,
        string $description,
        float  $price,
        int    $unitMeasureId,
        int    $store,
        int    $userId
    ): self
    {
        $product = new self();

        $product->setName($name);
        $product->setDescription($description);
        $product->setPrice($price);
        $product->setUnitMeasureId($unitMeasureId);
        $product->setStore($store);
        $product->setUserId($userId);

        return $product;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function getPrice(): float
    {
        return $this->price;
    }

    public function getUnitMeasureId(): int
    {
        return $this->unit_measure_id;
    }

    public function getStore(): int
    {
        return $this->store;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;
        return $this;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;
        return $this;
    }

    public function setUnitMeasureId(int $unitMeasureId): self
    {
        $this->unit_measure_id = $unitMeasureId;
        return $this;
    }

    public function setStore(int $store): self
    {
        $this->store = $store;
        return $this;
    }

    public function setUserId(int $userId): self
    {
        $this->user_id = $userId;
        return $this;
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function unitMeasure(): BelongsTo
    {
        return $this->belongsTo(UnitMeasure::class);
    }

    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(Category::class, 'catalog_products_categories')->withTimestamps()->using(ProductCategory::class);
    }

    public function images(): BelongsToMany
    {
        return $this->belongsToMany(Image::class, 'catalog_products_images')->withTimestamps()->using(ProductImage::class);
    }
}
