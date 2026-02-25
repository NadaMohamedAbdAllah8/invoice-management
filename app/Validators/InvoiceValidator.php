<?php

namespace App\Validators;

use App\Exceptions\ContractNotActiveException;
use App\Models\Contract;

class InvoiceValidator
{
    public static function throwExceptionIfContractIsInactive(Contract $contract): void
    {
        if (! $contract->is_active) {
            throw new ContractNotActiveException;
        }
    }
}
