<?php

namespace App\Helpers\Mappers;

use App\Exceptions\AppException;
use Carbon\Carbon;
use MongoDB\BSON\Binary;
use MongoDB\BSON\UTCDateTime;
use MongoDB\Model\BSONArray;
use MongoDB\Model\BSONDocument;
use Ramsey\Uuid\Exception\InvalidUuidStringException;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

class MongoMapper
{
    public static function fromMongoUuidArray(?array $array): array
    {
        if (!isset($array)) {
            return [];
        }
        return array_map(
            function ($id) {
                return self::fromMongoUuid($id);
            },
            $array
        );
    }

    public static function toMongoUuidArray(?array $array): array
    {
        if (!isset($array)) {
            return [];
        }
        return array_map(
        /**
         * @throws AppException
         */ function ($id) {
            return self::toMongoUuid($id);
        },
            $array
        );
    }

    public static function fromMongoUuid($value): ?string
    {
        if (!isset($value)) {
            return null;
        }
        if ($value == null) {
            return null;
        }
        if (self::isBinaryString($value)) {
            $uuid = Uuid::fromBytes($value);
            return $uuid->toString();
        }
        if ($value instanceof Binary) {
            $uuid = Uuid::fromBytes($value->getData());
            return $uuid->toString();
        }

        return $value;
    }

    /**
     * Copy from vendor/jenssegers/mongodb/src/Jenssegers/Mongodb/Query/Builder.php
     * line 843
     * @throws AppException
     */
    public static function toMongoUuid($id): ?Binary
    {
        try {
            if ($id == null) {
                return null;
            }
            if ($id instanceof Binary) {
                return $id;
            }
            if ($id instanceof UuidInterface) {
                return new Binary($id->getBytes(), Binary::TYPE_UUID);
            }
            if (self::isBinaryString($id)) {
                return new Binary($id, Binary::TYPE_UUID);
            }
            $uuid = Uuid::fromString($id);
            return new Binary($uuid->getBytes(), Binary::TYPE_UUID);
        } catch (InvalidUuidStringException $e) {
            throw new AppException("Invalid uuid string");
        }
    }

    public static function fromMongoDateTime($value): ?Carbon
    {
        if ($value == null) {
            return null;
        }
        if ($value instanceof UTCDateTime) {
            return Carbon::createFromTimestamp($value->toDateTime()->getTimestamp());
        } else {
            return Carbon::parse($value);
        }
    }

    public static function toMongoDateTime($value): ?UTCDateTime
    {
        if ($value == null) {
            return null;
        }
        if ($value instanceof UTCDateTime) {
            return $value;
        }
        if (!$value instanceof Carbon) {
            $value = Carbon::parse($value);
        }
        return new UTCDateTime($value->getTimestamp() * 1000);
    }

    public static function mapDocument($object): array
    {
        $ar = [];
        foreach ($object as $key => $value) {
            $key = ($key === '_id') ? 'id' : $key;
            switch ($value) {
                case $value instanceof Binary:
                    $value = self::fromMongoUuid($value);
                    break;
                case $value instanceof UTCDateTime:
                    $value = self::fromMongoDateTime($value);
                    break;
                case $value instanceof BSONArray:
                case $value instanceof BSONDocument:
                    $value = $value->jsonSerialize();
                    $value = self::mapDocument($value);
                    break;
            }
            $ar[$key] = $value;
        }
        return $ar;
    }

    private static function isBinaryString($str): bool
    {
        return is_string($str) && strlen($str) === 16 && preg_match('~[^\x20-\x7E\t\r\n]~', $str) > 0;
    }
}
