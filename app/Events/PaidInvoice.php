<?php

namespace App\Events;

use App\Models\Invoice;

class PaidInvoice
{
    public function __construct(public readonly Invoice $invoice) {}
}
