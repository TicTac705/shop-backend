<?php

namespace App\Models;

use App\Exceptions\AppException;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;
use Jenssegers\Mongodb\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Carbon;

/**
 * @property string $id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ModelBase extends Model
{
    use MongoBinaryUuid;
    use OrmMappingHelper;

//    protected $dateFormat = "Y-m-d\TH:i:s O";

    public static function boot()
    {
        parent::boot();
        self::bootMongodbBinaryUuid();
    }

    public function getId(): string
    {
        return $this->getIdAttribute();
    }

    public function getIdAttribute($value = null)
    {
        if (!$value && array_key_exists('_id', $this->attributes)) {
            $value = $this->attributes['_id'];
        }

        return $this->convertKeyToString($value);
    }

    public function getCreatedAtTimestamp(): ?int
    {
        return $this->created_at === null ? null : $this->created_at->timestamp;
    }

    public function getUpdatedAtTimestamp(): ?int
    {
        return $this->updated_at === null ? null : $this->updated_at->timestamp;
    }

    public function getById(string $id)
    {
        return self::where('_id', '=', $id)->firstOrFail();
    }

    /**
     * @param string[] $ids
     */
    public function getByIds(?array $ids): Collection
    {
        if ($ids === null) {
            return new Collection();
        }

        return self::query()->whereIn('_id', $ids)->get();
    }

    public function saveAndReturn(): self
    {
        $this->save();

        return $this;
    }

    public function saveAndReturnId(): string
    {
        $this->save();

        return $this->id;
    }

    public function checkChangesAndSave(): void
    {
        if ($this->isDirty()) {
            $this->touch();
            $this->save();
        }
    }

    public function checkChangesSaveAndReturn(): self
    {
        if ($this->isDirty()) {
            $this->touch();
            return $this->saveAndReturn();
        }

        return $this;
    }

    public function getListWithPagination(int $number, bool $isDisplayInactive = false): LengthAwarePaginator
    {
        if ($isDisplayInactive) {
            return self::query()->paginate($number);
        }

        return self::query()->where('is_active', '=', true)->paginate($number);
    }

    public function hasGetMutator($key): bool
    {
        if ($this->hasCast($key)) {
            return true;
        }

        return parent::hasGetMutator($key);
    }

    public function hasSetMutator($key): bool
    {
        if ($this->hasCast($key)) {
            return true;
        }

        return parent::hasSetMutator($key);
    }

    /**
     * Convert from mongo to php.
     * @param $key
     * @param $value
     * @return ModelBase|ModelBase[]|array|Carbon|mixed|string|null
     * @throws AppException
     */
    protected function mutateAttribute($key, $value)
    {
        if (method_exists($this, 'get' . Str::studly($key) . 'Attribute')) {
            return $this->{'get' . Str::studly($key) . 'Attribute'}($value);
        }
        $casts = $this->casts;
        if (array_key_exists($key, $casts)) {
            $type = $casts[$key];
            return $this->fromAttribute($type, $value);
        }
        return null;
    }

    /**
     * @throws AppException
     */
    protected function castAttribute($key, $value)
    {
        if (is_null($value)) {
            return null;
        }
        $type = $this->getCastType($key);

        return $this->fromAttribute($type, $value);
    }

    protected function getCastType($key)
    {
        if (array_key_exists($key, $this->casts)) {
            $type = $this->casts[$key];
            if (0 === strpos($type, 'class:') || 0 === strpos($type, 'class-array:')) {
                return $type;
            }
        }

        return parent::getCastType($key);
    }

    /**
     * Convert from php to mongo.
     * @param $key
     * @param $value
     * @throws AppException
     */
    protected function setMutatedAttributeValue($key, $value)
    {
        if (method_exists($this, 'set' . Str::studly($key) . 'Attribute')) {
            $this->{'set' . Str::studly($key) . 'Attribute'}($value);

            return;
        }
        $type = $this->getCastType($key);
        $this->attributes[$key] = $this->toAttribute($type, $value);
    }
}
