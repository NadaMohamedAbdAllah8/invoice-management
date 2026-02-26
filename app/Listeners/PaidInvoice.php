<?php

namespace App\Listeners;

use App\Events\PaidInvoice as PaidInvoiceEvent;
use Illuminate\Support\Facades\Log;

class PaidInvoice
{
    public function handle(PaidInvoiceEvent $event): void
    {
        Log::info('Invoice status changed to paid.', [
            'invoice_id' => $event->invoice->id,
            'invoice_number' => $event->invoice->invoice_number,
            'tenant_id' => $event->invoice->tenant_id,
        ]);
    }
}
