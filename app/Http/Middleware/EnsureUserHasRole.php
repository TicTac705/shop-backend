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
     * @param string $roles
     * @return Response|RedirectResponse
     */
    public function handle(Request $request, Closure $next, string $roles)
    {
        $roles = trim($roles);
        if (preg_match('/\|/', $roles)) {
            $roleList = explode("|", $roles);
            $res = $request->user()->hasRoles($roleList);
        } else {
            $res = $request->user()->hasRole($roles);
        }

        if ($res) {
            return $next($request);
        }

        return response('', HTTPResponseStatuses::FORBIDDEN);
    }
}
