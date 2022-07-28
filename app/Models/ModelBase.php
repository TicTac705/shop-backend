<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
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
    public function getId(): string
    {
        return $this->id;
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

    /**
     * @param ModelBase[] $records
     * @return bool
     */
    public function saveMany(array $records): bool
    {
        foreach ($records as &$record) {
            $record->updateTimestamps();
            $record = $record->getAttributes();
        }

        return self::insert($records);
    }

    /**
     * @param string[] $ids
     * @return bool
     */
    public function deleteManyByIds(array $ids): bool
    {
        return self::whereIn('id', $ids);
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
}
