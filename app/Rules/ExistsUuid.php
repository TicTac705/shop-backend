<?php

namespace App\Rules;

use App\Exceptions\AppException;
use App\Helpers\Mappers\MongoMapper;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;

class ExistsUuid implements Rule
{
    private string $table;

    /**
     * Create a new rule instance.
     *
     * @param $table
     */
    public function __construct($table)
    {
        $this->table = $table;
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     * @throws AppException
     */
    public function passes($attribute, $value): bool
    {
        return DB::table($this->table)->where('_id',  MongoMapper::toMongoUuid($value))->exists();
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'This :attribute does not exist!';
    }
}
