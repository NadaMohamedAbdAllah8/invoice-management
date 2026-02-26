<?php

namespace App\Observers;

use App\Enums\InvoiceStatus;
use App\Events\PaidInvoice;
use App\Models\Invoice;

class InvoiceObserver
{
    public function saved(Invoice $invoice): void
    {
        if (
            $invoice->wasChanged('status') &&
            $invoice->status->value === InvoiceStatus::PAID->value
        ) {
            event(new PaidInvoice(invoice: $invoice));
        }
    }
}
