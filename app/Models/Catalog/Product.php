<?php

namespace App\Models\Catalog;

use App\Exceptions\AppException;
use App\Models\Image;
use App\Models\ModelBase;
use App\Models\UnitMeasure;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Jenssegers\Mongodb\Eloquent\SoftDeletes;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property string $name
 * @property string $description
 * @property float $price
 * @property string $unit_measure_id
 * @property int $store
 * @property string[] $category_ids
 * @property null|string[] $image_ids
 * @property string $user_id
 * @property bool $is_active
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property null|Carbon $deleted_at
 *
 */
class Product extends ModelBase
{
    use HasFactory, SoftDeletes;

    protected $collection = 'catalog_products';

    protected $fillable = [
        'name',
        'description',
        'price',
        'unit_measure_id',
        'store',
        'category_ids',
        'image_ids',
        'user_id',
        'is_active'
    ];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $casts = [
        '_id' => 'uuid',
        'unit_measure_id' => 'uuid',
        'category_ids' => 'uuid-array',
        'image_ids' => 'uuid-array',
        'user_id' => 'uuid',
    ];

    /**
     * @param string $name
     * @param string $description
     * @param float $price
     * @param string $unitMeasureId
     * @param int $store
     * @param string[] $categoryIds
     * @param string $userId
     * @param bool $isActive
     * @param null|string[] $imageIds
     * @return $this
     */
    public function create(
        string $name,
        string $description,
        float  $price,
        string $unitMeasureId,
        int    $store,
        array  $categoryIds,
        string $userId,
        bool   $isActive,
        ?array $imageIds
    ): self
    {
        $product = new self();

        $product->setName($name);
        $product->setDescription($description);
        $product->setPrice($price);
        $product->setUnitMeasureId($unitMeasureId);
        $product->setStore($store);
        $product->setCategories($categoryIds);
        $product->setUserId($userId);
        $product->setIsActive($isActive);
        if ($imageIds !== null) {
            $product->setImages($imageIds);
        }

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

    /**
     * @throws AppException
     */
    public function getUnitMeasureId(): string
    {
        return $this->toAttribute('uuid', $this->unit_measure_id);
    }

    public function getStore(): int
    {
        return $this->store;
    }

    /**
     * @return string[]
     * @throws AppException
     */
    public function getCategories(): array
    {
        return $this->toAttribute('uuid-array', $this->category_ids);
    }

    /**
     * @return null|string[]
     * @throws AppException
     */
    public function getImages(): ?array
    {
        return $this->toAttribute('uuid-array', $this->image_ids);
    }

    /**
     * @throws AppException
     */
    public function getUserId(): string
    {
        return $this->toAttribute('uuid', $this->user_id);
    }

    public function getIsActive(): bool
    {
        return $this->is_active;
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

    public function setUnitMeasureId(string $unitMeasureId): self
    {
        $this->unit_measure_id = $unitMeasureId;
        return $this;
    }

    public function setStore(int $store): self
    {
        $this->store = $store;
        return $this;
    }

    /**
     * @param string[] $categoryIds
     * @return $this
     */
    public function setCategories(array $categoryIds): self
    {
        $this->category_ids = $categoryIds;
        return $this;
    }

    /**
     * @param string[] $imageIds
     * @return $this
     */
    public function setImages(array $imageIds): self
    {
        $this->image_ids = $imageIds;
        return $this;
    }

    public function setUserId(string $userId): self
    {
        $this->user_id = $userId;
        return $this;
    }

    public function setIsActive(bool $isActive): self
    {
        $this->is_active = $isActive;
        return $this;
    }

    /**
     * @throws AppException
     */
    public function unitMeasure(): UnitMeasure
    {
        return UnitMeasure::getById($this->getUnitMeasureId());
    }

    /**
     * @throws AppException
     */
    public function user(): User
    {
        return User::getById($this->getUserId());
    }

    /**
     * @throws AppException
     */
    public function categories(): Collection
    {
        return Category::getByIds($this->getCategories());
    }

    /**
     * @throws AppException
     */
    public function images(): ?Collection
    {
        return Image::getByIds($this->getImages());
    }

    public function getDeletedAtTimestamp(): ?int
    {
        return $this->deleted_at === null ? null : $this->deleted_at->timestamp;
    }
}
