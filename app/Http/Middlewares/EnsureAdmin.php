<?php

namespace App\Http\Middlewares;

use App\Exceptions\AuthorizationException;
use App\Models\Admin;
use App\Tenancy\TenantContext;
use Closure;
use Illuminate\Http\Request;

class EnsureAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (! auth()->user() instanceof Admin) {
            throw new AuthorizationException('Only admins can perform this action.');
        }

        return $next($request);
    }
}
