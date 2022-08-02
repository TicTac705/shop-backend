<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class Uuid implements Rule
{
    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value): bool
    {
        var_dump(\Ramsey\Uuid\Uuid::isValid($value));
        return \Ramsey\Uuid\Uuid::isValid($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message(): string
    {
        return 'The :attribute is not Uuid.';
    }
}
