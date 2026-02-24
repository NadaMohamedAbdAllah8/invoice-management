<?php

namespace App\Tenancy\Traits;

use App\Tenancy\Scopes\TenantScope;
use App\Tenancy\TenantContext;
use RuntimeException;

trait BelongsToTenant
{
    protected static function bootBelongsToTenant(): void
    {
        static::addGlobalScope(new TenantScope);

        static::creating(function ($model) {
            $tenantContext = app(TenantContext::class);

            if (! $tenantContext->hasTenant()) {
                throw new RuntimeException('TenantContext missing tenant_id.');
            }

            if (is_null($model->tenant_id)) {
                $model->tenant_id = $tenantContext->getTenantId();
            }
        });
    }
}
