<?php

namespace App\Exceptions;

use App\Helpers\Statuses\HTTPResponseStatuses;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Tymon\JWTAuth\Exceptions\JWTException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    public function render($request, Throwable $e)
    {
        if ($e instanceof JWTException) {
            return response()->json(['message' => 'Could not create token'], HTTPResponseStatuses::INTERNAL_SERVER_ERROR);
        }

        if ($e instanceof ModelNotFoundException) {
            return response()->json(['message' => $e->getMessage()], HTTPResponseStatuses::NOT_FOUND);
        }

        return parent::render($request, $e);
    }

    protected function unauthenticated($request, AuthenticationException $exception)
    {
        return response()->json(['message' => $exception->getMessage()], HTTPResponseStatuses::UNAUTHORIZED);
    }
}
