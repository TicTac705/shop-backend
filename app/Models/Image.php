<?php

namespace App\Models;

use App\Models\Catalog\Product;
use App\Models\User\User;
use App\PivotModels\Catalog\ProductImage;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property string $user_id;
 * @property string $name;
 * @property string $name_original;
 * @property int $size;
 * @property string $src;
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 */
class Image extends ModelBase
{
    protected $table = 'images';

    protected $fillable = [
        'user_id',
        'name',
        'name_original',
        'size',
        'src'
    ];

    protected $touches = ['products'];

    public function create(
        string $userId,
        string $name,
        string $nameOriginal,
        int    $size,
        string $src
    ): self
    {
        $img = new self();

        $img->setUserId($userId);
        $img->setName($name);
        $img->setNameOriginal($nameOriginal);
        $img->setSize($size);
        $img->setSrc($src);

        return $img;
    }

    public function getUserId(): string
    {
        return $this->user_id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getNameOriginal(): string
    {
        return $this->name_original;
    }

    public function getSize(): int
    {
        return $this->size;
    }

    public function getSrc(): string
    {
        return $this->src;
    }

    public function setUserId(string $userId): self
    {
        $this->user_id = $userId;
        return $this;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setNameOriginal(string $nameOriginal): self
    {
        $this->name_original = $nameOriginal;
        return $this;
    }

    public function setSize(int $size): self
    {
        $this->size = $size;
        return $this;
    }

    public function setSrc(string $src): self
    {
        $this->src = $src;
        return $this;
    }

    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class, 'catalog_products_images')->withTimestamps()->using(ProductImage::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
