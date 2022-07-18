<?php

namespace App\Rules;

use App\Helpers\Statuses\Order\DeliveryStatuses;
use Illuminate\Contracts\Validation\Rule;

class ExistsDeliveryStatus implements Rule
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
        return in_array($value, DeliveryStatuses::getConstants());
    }

    public function message(): string
    {
        return 'The :attribute not exists.';
    }
}
