<?php

namespace App\Rules;

use App\Helpers\Statuses\Order\OrderStatuses;
use Illuminate\Contracts\Validation\Rule;

class ExistsOrderStatus implements Rule
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
        return in_array($value, OrderStatuses::getConstants());
    }

    public function message(): string
    {
        return 'The :attribute not exists.';
    }
}
