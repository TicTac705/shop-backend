<?php

namespace App\Http\Middleware;

use App\Helpers\Statuses\HTTPResponseStatuses;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param Request $request
     * @return string|void
     */
    protected function redirectTo($request)
    {
//        if (!$request->expectsJson()) {
//            return response('', HTTPResponseStatuses::UNAUTHORIZED);
//        }

        if (!$request->expectsJson()) {
            return route('sign-in');
        }
    }
}
