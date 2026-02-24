<?php

namespace App\Tenancy\Scopes;

use App\Tenancy\TenantContext;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class TenantScope implements Scope
{
    public function apply(Builder $builder, Model $model): void
    {
        $tenantContext = app(TenantContext::class);

        if (! $tenantContext->hasTenant()) {
            return;
        }

        $builder->where($model->getTable().'.tenant_id', $tenantContext->getTenantId());
    }
}
