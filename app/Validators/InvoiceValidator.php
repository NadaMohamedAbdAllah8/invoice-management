<?php

namespace App\Validators;

use App\Enums\ContractStatus;
use App\Exceptions\ContractNotActiveException;
use App\Models\Contract;

class InvoiceValidator
{
    public static function throwExceptionIfContractIsNotActive(Contract $contract): void
    {
        if ($contract->status != ContractStatus::ACTIVE) {
            throw new ContractNotActiveException;
        }
    }
}
