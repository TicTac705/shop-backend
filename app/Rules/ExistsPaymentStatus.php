<?php

namespace App\Rules;

use App\Helpers\Statuses\Order\OrderPaymentStatuses;
use Illuminate\Contracts\Validation\Rule;

class ExistsPaymentStatus implements Rule
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
        return in_array($value, OrderPaymentStatuses::getConstants());
    }

    public function message(): string
    {
        return 'The :attribute not exists.';
    }
}
