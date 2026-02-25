<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class BelongsToTenant implements ValidationRule
{
    public function __construct(
        private string $modelClass,
        private string $column = 'id',
        private ?int $tenantId = null,
    ) {
        $this->tenantId ??= auth()->user()?->tenant_id;
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
