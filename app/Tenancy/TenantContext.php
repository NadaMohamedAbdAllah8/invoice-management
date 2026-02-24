<?php

namespace App\Tenancy;

class TenantContext
{
    private ?int $tenantId = null;

    public function register(): void
    {
        $this->app->singleton(TenantContext::class, fn () => new TenantContext);
    }

    public function setTenantId(int $tenantId): void
    {
        $this->tenantId = $tenantId;
    }

    public function getTenantId(): int
    {
        return $this->tenantId;
    }

    public function hasTenant(): bool
    {
        return ! is_null($this->tenantId);
    }
}
