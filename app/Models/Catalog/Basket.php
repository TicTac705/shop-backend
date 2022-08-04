<?php

namespace App\Models\Catalog;

use App\Models\ModelBase;
use App\PivotModels\Catalog\BasketProduct;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property string $user_id
 * @property bool $is_active
 * @property null|BasketProduct[] $positions
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 */
class Basket extends ModelBase
{
    use HasFactory;

    protected $collection = 'catalog_baskets';

    protected $fillable = [
        'user_id',
        'is_active',
        'positions'
    ];

    protected $casts = [
        '_id' => 'uuid',
        'user_id' => 'uuid',
        'positions' => 'class-array:'. BasketProduct::class,
        'positions.productId' => 'uuid'
    ];

    protected $dates = ['created_at', 'updated_at'];

    /**
     * @param string $userId
     * @param bool $isActive
     * @return $this
     */
    public function create(string $userId, bool $isActive = true): self
    {
        $basket = new self();

        $basket->setUserId($userId);
        $basket->setActive($isActive);
        $basket->setPositions([]);

        return $basket;
    }

    public function getUserId(): string
    {
        return $this->user_id;
    }

    public function getActive(): bool
    {
        return $this->is_active;
    }

    public function getPositions(): ?array
    {
        return $this->positions;
    }

    public function setUserId(string $userId): self
    {
        $this->user_id = $userId;
        return $this;
    }

    public function setActive(bool $isActive): self
    {
        $this->is_active = $isActive;
        return $this;
    }

    public function setPositions(array $positions): self
    {
        $this->positions = $positions;
        return $this;
    }
}
