<?php

namespace App\Helpers\Statuses\Order;

use App\Helpers\Statuses\StatusesBase;

class OrderStatuses extends StatusesBase
{
    public const PROCESSING = 1;
    public const ASSEMBLY = 2;
    public const SENDING = 3;
    public const DELIVERY = 4;
    public const DELIVERED = 5;
    public const COMPLETED = 6;
    public const CANCELED = 7;

    public const LIST = [
        self::PROCESSING,
        self::ASSEMBLY,
        self::SENDING,
        self::DELIVERY,
        self::DELIVERED,
        self::COMPLETED,
        self::CANCELED,
    ];
}
