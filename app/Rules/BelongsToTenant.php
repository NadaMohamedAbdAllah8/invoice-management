<?php

namespace App\Rules;

use App\Tenancy\TenantContext;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class BelongsToTenant implements ValidationRule
{
    public function __construct(
        private string $modelClass,
        private string $column = 'id',
        private ?int $tenantId = null,
    ) {
        $tenantContext = app(TenantContext::class);
        $this->tenantId = $tenantContext->getTenantId();
    }

    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $exists = ($this->modelClass)::query()
            ->where($this->column, $value)
            ->where('tenant_id', $this->tenantId)
            ->exists();

        if (! $exists) {
            $fail("The selected {$attribute} does not belong to your tenant.");
        }
    }
}
