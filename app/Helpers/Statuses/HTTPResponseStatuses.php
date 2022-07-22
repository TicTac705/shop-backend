<?php

namespace App\Helpers\Statuses;

class HTTPResponseStatuses extends StatusesBase
{
    /** Successful (Успешные) */
    public const OK = 200;
    public const CREATED = 201;
    public const ACCEPTED = 202;


    /** Client (Клиентские) */
    public const BAD_REQUEST = 400;
    public const UNAUTHORIZED = 401;
    public const FORBIDDEN = 403;
    public const NOT_FOUND = 404;
    public const UNPROCESSABLE_ENTITY = 422;

    /** Server (Серверные) */
    public const INTERNAL_SERVER_ERROR = 500;
}
