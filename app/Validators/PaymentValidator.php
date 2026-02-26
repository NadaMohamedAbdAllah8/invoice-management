<?php

namespace App\Validators;

use App\Enums\InvoiceStatus;
use App\Exceptions\InsufficientBalanceException;
use App\Exceptions\InvoiceCancelledException;
use App\Models\Invoice;

class PaymentValidator
{
    public static function throwExceptionIfInvoiceIsCancelled(Invoice $invoice): void
    {
        if ($invoice->status === InvoiceStatus::CANCELLED) {
            throw new InvoiceCancelledException;
        }
    }

    public static function throwExceptionIfAmountExceedsRemainingBalance(Invoice $invoice, float $amount): void
    {
        if (round($amount, 2) > round($invoice->remaining_balance, 2)) {
            throw new InsufficientBalanceException;
        }
    }
}
