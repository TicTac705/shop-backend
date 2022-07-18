<?php

namespace App\Helpers\Statuses\Order;

use App\Helpers\Statuses\StatusesBase;

class DeliveryStatuses extends StatusesBase
{
    public const SELF_DELIVERY = 1;
    public const COURIER_DELIVERY = 2;

    public const LIST = [
        self::SELF_DELIVERY,
        self::COURIER_DELIVERY
    ];
}
