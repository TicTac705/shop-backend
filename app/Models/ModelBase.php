<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 */
class ModelBase extends Model
{
    public function getId(): int
    {
        return $this->id;
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
}
