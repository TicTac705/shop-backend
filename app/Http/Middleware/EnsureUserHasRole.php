<?php

namespace App\Http\Middleware;

use App\Helpers\Statuses\HTTPResponseStatuses;
use Closure;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class EnsureUserHasRole
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure $next
     * @param string $role
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $role)
    {
        if ($request->user()->hasRole($role)) {
            return $next($request);
        }

        return response('', HTTPResponseStatuses::FORBIDDEN);
    }
}
