<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

class AdminRbac
{

    public function handle($request, Closure $next, $permission)
    {
        if ($permission == 'delete-key') {
            $license_id = $request->license_id;
            $license = License::find($license_id);

            if (can($permission) || $license->id_user == auth()->user()->id) {
                return $next($request);
            }
        }
        if (can($permission)) {
            return $next($request);
        }

        throw new AccessDeniedHttpException('Cannot access this page');
    }
}
