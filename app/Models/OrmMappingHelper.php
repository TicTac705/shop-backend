<?php

namespace App\Models;

use App\Exceptions\AppException;
use App\Helpers\Mappers\MongoMapper;
use MongoDB\BSON\Binary;
use MongoDB\BSON\UTCDateTime;

trait OrmMappingHelper
{
    /**
     * @throws AppException
     */
    protected function fromAttribute($type, $value)
    {
        if (strpos($type, 'class:') === 0) {
            if (!$value) {
                return null;
            }
            $className = explode(':', $type)[1];
            return $this->mapFromArray($value, $className);
        }
        if (strpos($type, 'class-array:') === 0) {
            if (!$value) {
                return [];
            }
            $className = explode(':', $type)[1];
            return array_map(fn($x) => $this->mapFromArray($x, $className), $value);
        }
        switch ($type) {
            case 'uuid':
                return MongoMapper::fromMongoUuid($value);
            case 'uuid-array':
                return MongoMapper::fromMongoUuidArray($value);
            case 'date':
            case 'datetime':
                if (!$value) {
                    return null;
                }
                return MongoMapper::fromMongoDateTime($value);
            default:
                throw new AppException("Unimplemented cast for type: " . $type);
        }
    }


    /**
     * @param $type
     * @param $value
     * @return array|Binary|UTCDateTime|null
     * @throws AppException
     */
    protected function toAttribute($type, $value)
    {
        if (is_null($value)) {
            return null;
        }

        if (strpos($type, 'class:') === 0) {
            $className = explode(':', $type)[1];
            return $this->mapToArray($value, $className);
        }

        if (strpos($type, 'class-array:') === 0) {
            $className = explode(':', $type)[1];
            return array_map(fn($x) => $this->mapToArray($x, $className), $value);
        }

        switch ($type) {
            case 'uuid':
                return MongoMapper::toMongoUuid($value);
            case 'uuid-array':
                return MongoMapper::toMongoUuidArray($value);
            case 'date':
            case 'datetime':
                return MongoMapper::toMongoDateTime($value);
            default:
                throw new AppException("Unimplemented cast for type: " . $type);
        }
    }

    protected function getUuidAttr(string $key): ?string
    {
        if (!isset($this->attributes[$key])) {
            return null;
        }
        return MongoMapper::fromMongoUuid($this->attributes[$key]);
    }

    /**
     * @throws AppException
     */
    protected function setUuidAttr(string $key, $value)
    {
        $this->attributes[$key] = MongoMapper::toMongoUuid($value);
    }

    private function mapToArray($value, $className)
    {
        return $value instanceof ModelBase ? $value->getOriginal() : $className::toArray($value);
    }

    private function mapFromArray($value, $className)
    {
        $res = new $className();

        if ($res instanceof ModelBase) {
            $res->setRawAttributes($value);
        } else {
            $res = $className::fromArray($value);
        }

        return $res;
    }
}
