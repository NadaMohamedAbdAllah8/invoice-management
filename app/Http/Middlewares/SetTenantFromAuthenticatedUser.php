<?php

namespace App\Http\Middlewares;

use App\Tenancy\TenantContext;
use Closure;
use Illuminate\Http\Request;

class SetTenantFromAuthenticatedUser
{
    public function handle(Request $request, Closure $next)
    {
        $tenantContext = app(TenantContext::class);

        $tenantContext->setTenantId(auth()->user()->tenant_id);

        return $next($request);
    }
}
