<?php

namespace App\Models\Catalog;

use App\Models\ModelBase;
use App\Models\User\User;
use App\PivotModels\Catalog\BasketProduct;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property int $user_id
 * @property bool $is_active
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 */
class Basket extends ModelBase
{
    protected $table = 'catalog_baskets';

    protected $fillable = [
        'user_id',
        'is_active'
    ];

    protected $casts = [
        'id' => 'integer',
        'user_id' => 'integer',
        'is_active' => 'boolean'
    ];

    protected $dates = ['created_at', 'updated_at'];

    public function create(int $userId, bool $isActive = true): self
    {
        $basket = new self();

        $basket->setUserId($userId);
        $basket->setActive($isActive);

        return $basket;
    }

    public function getUserId(): int
    {
        return $this->user_id;
    }

    public function getActive(): bool
    {
        return $this->is_active;
    }

    public function setUserId(int $userId): self
    {
        $this->user_id = $userId;
        return $this;
    }

    public function setActive(bool $isActive): self
    {
        $this->is_active = $isActive;
        return $this;
    }

    public function items(): HasMany
    {
        return $this->hasMany(BasketProduct::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
