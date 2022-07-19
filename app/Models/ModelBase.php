<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class ModelBase extends Model
{
    public function getId(): int
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


    public function saveAndReturn(): ModelBase
    {
        $this->save();

        return $this;
    }

    public function saveAndReturnId(): int
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
     * @param int[] $ids
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
}
