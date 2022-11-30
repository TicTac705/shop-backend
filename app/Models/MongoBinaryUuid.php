<?php

namespace App\Models;

use App\Exceptions\AppException;
use App\Helpers\Mappers\MongoMapper;
use Jenssegers\Mongodb\Eloquent\Model;
use MongoDB\BSON\Binary;
use Ramsey\Uuid\Uuid;

trait MongoBinaryUuid
{
    protected static function bootMongodbBinaryUuid()
    {
        static::creating(
            function (Model $model) {
                if ($model->{$model->getKeyName()}) {
                    return;
                }
                $model->{$model->getKeyName()} = Uuid::uuid1()->toString();
            }
        );
    }

    public function convertKeys(array $value): array
    {
        return array_map(
        /**
         * @throws AppException
         */ function ($id) {
                return $this->convertKey($id);
            },
            $value
        );
    }

    public function convertKeyToString($value): ?string
    {
        return MongoMapper::fromMongoUuid($value);
    }

    public function convertKeysToString($value): array
    {
        return MongoMapper::fromMongoUuidArray($value);
    }

    /**
     * @throws AppException
     */
    public function convertKey($id): ?Binary
    {
        if ($id == null) {
            return $id;
        }
        return MongoMapper::toMongoUuid($id);
    }
}
