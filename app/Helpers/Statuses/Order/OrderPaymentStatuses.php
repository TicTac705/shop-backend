<?php

namespace App\Helpers\Statuses\Order;

use App\Helpers\Statuses\StatusesBase;

class OrderPaymentStatuses extends StatusesBase
{
    public const NOT_PAID = 1;
    public const PARTIALLY_PAID = 2;
    public const PAID = 3;

    public const LIST = [
        self::NOT_PAID,
        self::PARTIALLY_PAID,
        self::PAID
    ];
}
