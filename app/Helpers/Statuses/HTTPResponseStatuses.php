<?php

namespace App\Helpers\Statuses;

class HTTPResponseStatuses
{
    /**
     * Successful (Успешные)
     */
    public const OK = 200;


    /**
     * Client (Клиентские)
     */
    public const BAD_REQUEST = 400;
    public const UNAUTHORIZED = 401;
    public const FORBIDDEN = 403;
}
