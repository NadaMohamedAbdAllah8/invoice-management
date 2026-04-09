<?php

namespace App\Http\Middlewares;

use App\Exceptions\AuthorizationException;
use App\Tenancy\TenantContext;
use Closure;
use Illuminate\Http\Request;

class SetTenantFromAuthenticatedUser
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (is_null($user?->tenant_id)) {
            throw new AuthorizationException('This endpoint is only available for tenant users.');
        }

        $tenantContext = app(TenantContext::class);
        $tenantContext->setTenantId($user->tenant_id);

        return $next($request);
    }
}
